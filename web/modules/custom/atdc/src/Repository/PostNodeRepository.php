<?php

namespace Drupal\atdc\Repository;

use Drupal\node\NodeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

final class PostNodeRepository {

  public function __construct(
    private EntityTypeManagerInterface $entityTypeManager,
  ) {
  }

  /**
   * @returns array<int, NodeInterface>
   */
  public function findAll(): array {
    $nodeStorage = $this->entityTypeManager->getStorage('node');
    $nodes = $nodeStorage->loadMultiple();

    return $nodes;
  }
}
