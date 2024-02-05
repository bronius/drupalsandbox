<?php

namespace Drupal\Tests\example\Unit;

use Drupal\atdc\PostWrapper;
use Drupal\node\NodeInterface;
use Drupal\Tests\UnitTestCase;

final class PostWrapperTest extends UnitTestCase {

  /** @test */
  public function it_wraps_a_post(): void {
    $node = $this->createMock(NodeInterface::class);
    $node->method('bundle')->willReturn('post');
    $wrapper = new PostWrapper($node);

    self::assertInstanceOf(NodeInterface::class, $node);
    self::assertSame('post', $node->bundle());
    self::assertSame('post', $wrapper->getType());
  }

  /**
   * @test
   * @testdox It can't wrap a page
   */
  public function it_cant_wrap_a_page(): void {
    self::expectException(\InvalidArgumentException::class);

    $node = $this->createMock(NodeInterface::class);
    $node->method('bundle')->willReturn('page');
    $wrapper = new PostWrapper($node);

    self::assertSame('post', $wrapper->getType());
  }

}
