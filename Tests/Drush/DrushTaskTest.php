<?php

namespace lastcall\Phing\Tests\Drush;

use lastcall\Phing\Tests\Phing\BaseTaskTest;

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