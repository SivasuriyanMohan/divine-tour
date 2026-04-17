<?php

namespace Drupal\temple_recommendation\Service;
 
use Drupal\node\Entity\Node;
use Drupal\user\Entity\User;
 
class RecommendationService {
 
  public function getRecommendations(User $user, $limit = 10) {
    $query = \Drupal::entityQuery('node')
      ->condition('type', 'temple')
      ->condition('status', 1);
 
    $nids = $query->execute();
    $nodes = Node::loadMultiple($nids);
 
    $recommended = [];
 
    foreach ($nodes as $node) {
      $score = 0;
 
      // 1. Favorite match
      $favorites = $user->get('field_favorite_temples')->getValue();
      foreach ($favorites as $fav) {
        if ($fav['target_id'] == $node->id()) {
          $score += 50;
        }
      }
 
      // 2. Spirituality match
      if (!$node->get('field_spirituality')->isEmpty() && !$user->get('field_preferred_spirituality')->isEmpty()) {
        if ($node->get('field_spirituality')->target_id == $user->get('field_preferred_spirituality')->target_id) {
          $score += 30;
        }
      }
 
      // 3. Random fallback (basic diversity)
      $score += rand(1, 10);
 
      $recommended[$node->id()] = $score;
    }
 
    arsort($recommended);
 
    return array_slice(array_keys($recommended), 0, $limit);
  }
}
 
function temple_engagement_node_view(array &$build, \Drupal\node\NodeInterface $node) {
  if ($node->bundle() == 'temple') {
    \Drupal::database()->merge('temple_popularity')
      ->key(['nid' => $node->id()])
      ->fields(['views' => 1])
      ->expression('views', 'views + 1')
      ->execute();
  }
}
 
$score = (views * 1) + (favorites * 3) + (visits * 5);
 
function temple_validation_entity_presave(\Drupal\Core\Entity\EntityInterface $entity) {
  if ($entity->getEntityTypeId() == 'node' && $entity->bundle() == 'temple') {
 
    $name = $entity->getTitle();
    $location = $entity->get('field_location')->value;
 
    $query = \Drupal::entityQuery('node')
      ->condition('type', 'temple')
      ->condition('title', $name)
      ->condition('field_location', $location)
      ->condition('nid', $entity->id(), '!=');
 
    $result = $query->execute();
 
    if (!empty($result)) {
      throw new \Drupal\Core\Entity\EntityStorageException('Duplicate temple detected.');
    }
  }
}
 