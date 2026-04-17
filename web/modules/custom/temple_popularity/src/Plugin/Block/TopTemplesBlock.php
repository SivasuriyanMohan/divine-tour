<?php
 
namespace Drupal\temple_popularity\Plugin\Block;
 
use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;
 
/**
 * Provides a 'Top Temples' Block.
 *
 * @Block(
 *   id = "top_temples_block",
 *   admin_label = @Translation("Top Temples"),
 * )
 */
class TopTemplesBlock extends BlockBase {
 
  public function build() {
 
    // Step 1: Get all temple nodes
    $nids = \Drupal::entityQuery('node')
      ->condition('type', 'temple')
      ->condition('status', 1)
      ->execute();
 
    if (empty($nids)) {
      return ['#markup' => 'No temples found'];
    }
 
    $nodes = Node::loadMultiple($nids);
 
    $scores = [];
 
    // Step 2: Calculate score per temple
    foreach ($nodes as $node) {
      $nid = $node->id();
 
      // Count favorites
      $favorites = \Drupal::entityQuery('flagging')
        ->condition('flag_id', 'favorite')
        ->condition('entity_id', $nid)
        ->count()
        ->execute();
 
      // Count visits
      $visits = \Drupal::entityQuery('flagging')
        ->condition('flag_id', 'visited')
        ->condition('entity_id', $nid)
        ->count()
        ->execute();
 
      // Score formula
      $score = ($favorites * 3) + ($visits * 1);
 
      $scores[$nid] = $score;
    }
 
    // Step 3: Sort descending
    arsort($scores);
 
    // Step 4: Pick top 5
    $top_nids = array_slice(array_keys($scores), 0, 5);
 
    // Step 5: Build render list
    $items = [];
 
    foreach ($top_nids as $nid) {
      $node = Node::load($nid);
 
      if ($node) {
        $items[] = $node->toLink()->toString();
      }
    }
 
    return [
      '#theme' => 'item_list',
      '#items' => $items,
      
      '#cache' => [
        'max-age' => 0, // disable cache for now (important during testing)
      ],
    ];
  }
}
 