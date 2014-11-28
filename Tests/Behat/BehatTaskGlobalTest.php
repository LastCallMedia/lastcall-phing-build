<?php

namespace lastcall\Phing\Tests\Behat;

use lastcall\Phing\Tests\Phing\BaseTaskTest;

class BehatTaskGlobalTest extends BaseTaskTest {

  protected $taskFile = 'behat.global.xml';

  /**
   * @dataProvider optionTaskProvider
   */
  public function testOptions($targetName, $expected) {
    $this->assertEquals($expected, $this->getCommandExecutedByTarget($targetName));
  }
}