<?php

namespace Drupal\Tests\atdc\Kernel;

use Drupal\atdc\Repository\PostNodeRepository;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\KernelTests\Core\Entity\EntityKernelTestBase;
use Drupal\node\NodeInterface;
use Drupal\Tests\node\Traits\NodeCreationTrait;

class PostNodeRepositoryTest extends EntityKernelTestBase {

  use NodeCreationTrait;

  protected static $modules = ['node', 'atdc'];

  public function testpostsAreReturnedByCreatedDate(): void {
    // Arrange.
    $this->createNode([
      'created' => (new DrupalDateTime('-1 week'))->getTimestamp(),
      'title' => 'Post one',
      'type' => 'post',
    ]);

    $this->createNode([
      'created' => (new DrupalDateTime('-8 days'))->getTimestamp(),
      'title' => 'Post two',
      'type' => 'post',
    ]);

    $this->createNode([
      'created' => (new DrupalDateTime('yesterday'))->getTimestamp(),
      'title' => 'Post three',
      'type' => 'post',
    ]);

    // Act.
    $postRepository = $this->container->get(PostNodeRepository::class);
    assert($postRepository instanceof PostNodeRepository);
    $nodes = $postRepository->findAll();

    // Assert.
    self::assertCount(3, $nodes);
    self::assertSame(
      ['Post two', 'Post one', 'Post three'],
      array_map(fn (NodeInterface $node) => $node->label(),
        $nodes
      )
    );
  }
}
