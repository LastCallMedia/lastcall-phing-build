<?php

namespace lastcall\Phing\Tests\Drush;

use lastcall\Phing\Tests\Phing\BaseTaskTest;

class DrushTaskGlobalTest extends BaseTaskTest {
  protected $taskFile = 'drush.global.xml';

  /**
   * @dataProvider optionTaskProvider
   */
  public function testOptions($targetName, $expected) {
    $this->assertEquals($expected, $this->getCommandExecutedByTarget($targetName));
  }
}