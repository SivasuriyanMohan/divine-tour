<?php
 
namespace Drupal\temple_testimonials\Plugin\Block;
 
use Drupal\Core\Block\BlockBase;
use Drupal\comment\Entity\Comment;
 
/**
 * Provides a 'Temple Testimonials' Block.
 *
 * @Block(
 *   id = "temple_testimonials_block",
 *   admin_label = @Translation("Temple Testimonials Block")
 * )
 */
class TempleTestimonialsBlock extends BlockBase {
 
  public function build() {
    $storage = \Drupal::entityTypeManager()->getStorage('comment');
 
    // Query latest 3 comments
    $cids = \Drupal::entityQuery('comment')
      ->condition('status', 1)
      ->condition('entity_type', 'node')
      ->sort('created', 'DESC')
      ->range(0, 3)
      ->execute();
 
    $comments = $storage->loadMultiple($cids);
 
    $items = [];
 
    foreach ($comments as $comment) {
      $node = $comment->getCommentedEntity();
 
      // Filter only Temple content type
      if ($node && $node->bundle() === 'temple') {
        $items[] = [
          'comment' => [
            '#type' => 'processed_text',
            '#text' => $comment->get('comment_body')->value,
            '#format' => $comment->get('comment_body')->format,
          ],
          'author' => $comment->getOwner()->getDisplayName(),
          'title' => $node->label(),
        ];
      }
    }
 
    return [
      '#theme' => 'temple_testimonials',
      '#items' => $items,
      '#attached' => [
        'library' => [
            'temple_testimonials/testimonial_slider',
        ],
      ],
      '#cache' => [
        'max-age' => 0, // disable cache for now (can optimize later)
      ],
    ];
  }
}
 