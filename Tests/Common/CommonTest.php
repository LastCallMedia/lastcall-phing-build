<?php


namespace lastcall\Phing\Tests\Common;

class CommonTest extends \BuildFileTest {

  protected function setUp() {
    $this->configureProject(__DIR__ . '/../Resources/common-test.xml');
    $this->executeTarget('test-setup');
  }

  protected function tearDown() {
    $this->executeTarget('test-teardown');
  }

  public function testBehatSetup() {
    $this->executeTarget('drupal-setup-behat');
    $dir = $this->getProject()->getProperty('project.dir.behat');
    $this->assertFileExists($dir . '/behat.local.yml');
    $this->assertFileExists($dir . '/behat.yml');
    $this->assertStringEqualsFile($dir . '/.gitignore', 'behat.local.yml');
  }



  /**
   * Get the project which has been configured for a test.
   *
   * @return \Project the Project instance for this test.
   */
  protected function getProject() {
    return $this->project;
  }
}