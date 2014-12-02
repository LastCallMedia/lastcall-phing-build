<?php

namespace lastcall\Phing\Tests\Behat;

use lastcall\Phing\Tests\Phing\BaseTaskTest;

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