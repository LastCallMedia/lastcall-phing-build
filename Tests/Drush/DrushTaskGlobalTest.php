<?php

namespace lastcall\phing\Tests\Drush;

use lastcall\phing\Tests\Phing\BaseTaskTest;

class DrushTaskGlobalTest extends BaseTaskTest {

  public function getTaskFile() {
    return __DIR__ . '/../Resources/drush.global.xml';
  }

  /**
   * @dataProvider optionTaskProvider
   */
  public function testOptions($targetName, $expected) {
    $this->assertEquals($expected, $this->getCommandExecutedByTarget($targetName));
  }
}