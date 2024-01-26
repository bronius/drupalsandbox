<?php

namespace Drupal\Tests\example\Functional;

use Drupal\Tests\BrowserTestBase;
use Symfony\Component\HttpFoundation\Response;

class BlogPageTest extends BrowserTestBase {

  protected $defaultTheme = 'stark';

  protected static $modules = ['node', 'example'];

  public function testBlogPage(): void {
    $out = $this->drupalGet('/blog');
    var_dump($out);

    $this->assertSession()->statusCodeEquals(Response::HTTP_OK);

  }
}
