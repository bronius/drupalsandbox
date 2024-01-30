<?php

namespace Drupal\Tests\atdc\Kernel;

use Drupal\atdc\Builder\PostBuilder;
use Drupal\atdc\Repository\PostNodeRepository;
use Drupal\KernelTests\Core\Entity\EntityKernelTestBase;
use Drupal\node\NodeInterface;
use Drupal\Tests\node\Traits\NodeCreationTrait;

class PostNodeRepositoryTest extends EntityKernelTestBase {

  use NodeCreationTrait;

  protected static $modules = ['node', 'atdc'];

  public function testpostsAreReturnedByCreatedDate(): void {
    // Arrange.
    PostBuilder::create()
      ->setCreated('-1 week')
      ->setTitle('Post one')
      ->getPost();

    PostBuilder::create()
      ->setCreated('-8 days')
      ->setTitle('Post two')
      ->getPost();

    PostBuilder::create()
      ->setCreated('yesterday')
      ->setTitle('Post three')
      ->getPost();

    // Act.
    $postRepository = $this->container->get(PostNodeRepository::class);
    assert($postRepository instanceof PostNodeRepository);
    $nodes = $postRepository->findAll();

    // Assert.
    self::assertCount(3, $nodes);
    self::assertNodeTitlesAreSame(['Post two', 'Post one', 'Post three'], $nodes);
  }

  /**
   * @param array<int, string> $expectedTitles
   * @param array<int, NodeInterface> $nodes
   * @return void
   */
  private static function assertNodeTitlesAreSame(
    array $expectedTitles,
    array $nodes,
  ): void {
    self::assertSame(
      $expectedTitles,
      array_map(
        fn (NodeInterface $node) => $node->label(),
        $nodes
      )
    );
  }
}
