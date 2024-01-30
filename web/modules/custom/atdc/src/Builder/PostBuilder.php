<?php

namespace Drupal\atdc\Builder;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;

final class PostBuilder {

  private ?DrupalDateTime $created = NULL;

  private string $title;

  public static function create(): self {
    return new self();
  }

  /**
   * @param DrupalDateTime|null $created
   */
  public function setCreated(string $time = 'now'): self {
    $this->created = new DrupalDateTime($time);
    return $this;
  }

  public function setTitle(string $title): self {
    $this->title = $title;
    return $this;
  }

  public function getPost(): NodeInterface {
    $post = Node::create([
      'created' => $this->created?->getTimestamp(),
      'title' => $this->title,
      'type' => 'post',
    ]);
    $post->save();
    return $post;
  }

}
