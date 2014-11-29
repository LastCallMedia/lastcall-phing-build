<?php

namespace lastcall\phing\Tests\Drush;

use lastcall\phing\Tests\Phing\BaseTaskTest;

class DrushTaskTest extends BaseTaskTest {

  public function getTaskFile() {
    return __DIR__ . '/../Resources/drush.xml';
  }

  /**
   * @dataProvider optionTaskProvider
   */
  public function testOptions($targetName, $expected) {
    $this->assertEquals($expected, $this->getCommandExecutedByTarget($targetName));
  }
}