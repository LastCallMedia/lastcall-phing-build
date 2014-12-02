<?php

namespace lastcall\Phing\Tests\Behat;

use lastcall\Phing\Behat\BehatTask;
use lastcall\Phing\Tests\Phing\BaseTaskTest;

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