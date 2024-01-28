<?php

namespace Drupal\Tests\atdc\Functional;

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
}
