<?php

namespace Drupal\Tests\example\Functional;

use Drupal\Tests\BrowserTestBase;
use Symfony\Component\HttpFoundation\Response;

class BlogPageTest extends BrowserTestBase {

  protected $defaultTheme = 'stark';

  protected static $modules = ['node', 'example'];

  public function testBlogPage(): void {
    $this->drupalGet('/blog');

    $this->assertSession()->statusCodeEquals(Response::HTTP_OK);

  }
}
