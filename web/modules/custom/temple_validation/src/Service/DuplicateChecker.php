<?php

namespace Drupal\temple_validation\Service;
 
use Drupal\node\Entity\Node;
 
class DuplicateChecker {
 
  public function check($entity) {
 
    if ($entity->bundle() !== 'temple') {
      return;
    }
 
    $title = $this->normalizeName($entity->getTitle());
    $lat = $entity->get('field_latitude')->value;
    $lng = $entity->get('field_longitude')->value;
 
    // Load all temples (we'll optimize later)
    $query = \Drupal::entityQuery('node')
      ->condition('type', 'temple')
      ->condition('nid', $entity->id(), '!=');
 
    $nids = $query->execute();
    $nodes = Node::loadMultiple($nids);
 
    foreach ($nodes as $node) {
 
      $existing_title = $this->normalizeName($node->getTitle());
 
      similar_text($title, $existing_title, $percent);
 
      $distance = $this->calculateDistance(
        $lat,
        $lng,
        $node->get('field_latitude')->value,
        $node->get('field_longitude')->value
      );
 
      if ($percent > 80 && $distance < 0.5) {
        throw new \Exception('Duplicate temple detected near same location.');
      }
    }
  }
 
  private function normalizeName($name) {
    $name = strtolower($name);
    $name = preg_replace('/[^a-z0-9 ]/', '', $name);
    $name = str_replace(['temple', 'shri', 'sri'], '', $name);
    return trim($name);
  }
 
  private function calculateDistance($lat1, $lon1, $lat2, $lon2) {
    $earth_radius = 6371;
 
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
 
    $a = sin($dLat/2) * sin($dLat/2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon/2) * sin($dLon/2);
 
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
 
    return $earth_radius * $c;
  }
}