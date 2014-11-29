<?php

namespace lastcall\phing\Tests\Behat;

use lastcall\phing\Tests\Phing\BaseTaskTest;

class BehatTaskGlobalTest extends BaseTaskTest {

  public function getTaskFile() {
    return __DIR__ . '/../Resources/behat.global.xml';
  }

  /**
   * @dataProvider optionTaskProvider
   */
  public function testOptions($targetName, $expected) {
    $this->assertEquals($expected, $this->getCommandExecutedByTarget($targetName));
  }
}