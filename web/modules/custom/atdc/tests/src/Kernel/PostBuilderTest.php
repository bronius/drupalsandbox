<?php

namespace Drupal\Tests\atdc\Kernel;

use Drupal\atdc\Builder\PostBuilder;
use Drupal\KernelTests\Core\Entity\EntityKernelTestBase;
use Drupal\node\NodeInterface;

final class PostBuilderTest extends EntityKernelTestBase {

  protected static $modules = [
    // Core
    'node', 'taxonomy',
    // Custom
    'atdc', 'atdc_test'
  ];

  /** @test */
  public function it_returns_a_published_post(): void {

    $this->installConfig(modules: [
      'atdc_test',
    ]);


    $node = PostBuilder::create()
      ->setTitle('test')
      ->getPost();

    self::assertInstanceOf(NodeInterface::class, $node);
    self::assertSame('post', $node->bundle());
    self::assertTrue($node->isPublished());
  }

  /** @test */
  public function it_returns_an_unpublished_post(): void {

    $this->installConfig(modules: [
      'atdc_test',
    ]);

    $node = PostBuilder::create()
      ->setTitle('test')
      ->isNotPublished()
      ->getPost();

    self::assertInstanceOf(NodeInterface::class, $node);
    self::assertSame('post', $node->bundle());
    self::assertFalse($node->isPublished());
  }

  /** @test */
  public function it_returns_a_post_with_tags(): void {

    $this->installConfig(modules: [
      'atdc_test',
    ]);

    $node = PostBuilder::create()
      ->setTitle('test')
      ->setTags(['Drupal', 'PHP', 'Testing'])
      ->getPost();

    self::assertInstanceOf(NodeInterface::class, $node);
    self::assertSame('post', $node->bundle());

    $tags = $node->get('field_tags')->referencedEntities();
    self::assertCount(3, $tags);
  }
}
