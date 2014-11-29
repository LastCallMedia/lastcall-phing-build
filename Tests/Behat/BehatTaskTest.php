<?php

namespace lastcall\phing\Tests\Behat;

use lastcall\phing\Behat\BehatTask;
use lastcall\phing\Tests\Phing\BaseTaskTest;

class BehatTaskTest extends BaseTaskTest {

  public function getTaskFile() {
    return __DIR__ . '/../Resources/behat.xml';
  }

  /**
   * @dataProvider optionTaskProvider
   */
  public function testOptions($targetName, $expected) {
    $this->assertEquals($expected, $this->getCommandExecutedByTarget($targetName));
  }
}