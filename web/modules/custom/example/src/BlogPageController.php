<?php

namespace Drupal\example;

use Drupal\Core\Controller\ControllerBase;

class BlogPageController extends ControllerBase {

  public function __invoke(): array {
    $nodeStorage = $this->entityTypeManager()->getStorage('node');
    $nodes = $nodeStorage->loadMultiple();

    $build = [];
    $build['content']['#theme'] = 'item_list';
    foreach ($nodes as $node) {
      $build['content']['#items'][] = $node->label();
    }

    return $build;
  }
}
