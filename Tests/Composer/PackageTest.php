<?php

namespace lastcall\Phing\Tests\Composer;

use Composer\IO\NullIO;
use Composer\Util\ConfigValidator;

class PackageTest extends \PHPUnit_Framework_TestCase {

  function testComposerJSON() {
    $io = new NullIO();
    $validator = new ConfigValidator($io);

    list($errors, $publishErrors, $warnings) = $validator->validate(__DIR__.'/../../composer.json');
    foreach($errors as $error) {
      $this->fail($error);
    }
    foreach($publishErrors as $error) {
      $this->fail($error);
    }
    foreach($warnings as $warning) {
      $this->fail($warning);
    }
  }
}