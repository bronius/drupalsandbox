<?php

namespace Drupal\atdc;

use Drupal\node\NodeInterface;

final class PostWrapper {
  public function __construct(private NodeInterface $post) {
    if ($this->post->bundle() !== 'post') {
      throw new \InvalidArgumentException();
    }
  }

  public function getType(): string {
    return $this->post->bundle();
  }
}
