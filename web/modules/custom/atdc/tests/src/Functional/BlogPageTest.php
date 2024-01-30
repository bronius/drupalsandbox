<?php

namespace Drupal\Tests\atdc\Functional;

use Drupal\atdc\Builder\PostBuilder;
use Drupal\Tests\BrowserTestBase;
use Symfony\Component\HttpFoundation\Response;

class BlogPageTest extends BrowserTestBase {

  protected $defaultTheme = 'stark';

  protected static $modules = ['node', 'atdc'];

  public function testBlogPage(): void {
    $this->drupalGet('/blog');

    $this->assertSession()->statusCodeEquals(Response::HTTP_OK);

  }

  public function testPostsAreVisible(): void {
    // Arrange.
    $this->createNode(['type' => 'post', 'title' => 'First post']);
    $this->createNode(['type' => 'post', 'title' => 'Second post']);
    $this->createNode(['type' => 'post', 'title' => 'Third post']);

    // Act.
    $this->drupalGet('/blog');

    // Assert.
    $assert = $this->assertSession();
    $assert->pageTextContains('First post');
    $assert->pageTextContains('Second post');
    $assert->pageTextContains('Third post');
  }

  public function testOnlyPublishedNodesAreShown(): void {
    PostBuilder::create()
      ->setTitle('Post one')
      ->isPublished()
      ->getPost();

    PostBuilder::create()
      ->setTitle('Post two')
      ->isNotPublished()
      ->getPost();

    PostBuilder::create()
      ->setTitle('Post three')
      ->isPublished()
      ->getPost();

    $this->drupalGet('/blog');

    $assert = $this->assertSession();
    $assert->pageTextContains('Post one');
    $assert->pageTextNotContains('Post two');
    $assert->pageTextContains('Post three');
  }

  public function testOnlyPostNodesAreShown(): void {
    PostBuilder::create()->setTitle('Post one')->getPost();
    PostBuilder::create()->setTitle('Post two')->getPost();

    $this->createNode([
      'title' => 'This is not a post',
      'type' => 'page',
    ]);

    $this->drupalGet('/blog');

    $assert = $this->assertSession();
    $assert->pageTextContains('Post one');
    $assert->pageTextContains('Post two');
    $assert->pageTextNotContains('This is not a post');
  }

}
