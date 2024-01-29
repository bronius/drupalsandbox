<?php

namespace Drupal\atdc\Controllers;

use Drupal\atdc\Repository\PostNodeRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Controller\ControllerBase;

class BlogPageController extends ControllerBase {

  public function __construct(
    private PostNodeRepository $postNodeRepository,
  ) {
  }

  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get(PostNodeRepository::class),
    );
}

  public function __invoke(): array {
    $nodes = $this->postNodeRepository->findAll();

    $build = [];
    $build['content']['#theme'] = 'item_list';
    foreach ($nodes as $node) {
      $build['content']['#items'][] = $node->label();
    }

    return $build;
  }
}
