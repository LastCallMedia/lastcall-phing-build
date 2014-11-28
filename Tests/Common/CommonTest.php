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
    $this->executeTarget('setup:behat');
    $dir = $this->getProject()->getProperty('project.dir.behat');
    $this->assertFileExists($dir . '/behat.local.yml');
    $this->assertFileExists($dir . '/behat.yml');
    $this->assertFileExists($dir .'/bootstrap/FeatureContext.php');
    $this->assertStringEqualsFile($dir . '/.gitignore', 'behat.local.yml');
  }

  /**
   * Assert that we can run setup against a directory without it
   * destroying code we already have in place.
   */
  public function testBehatReSetup() {
    $dir = $this->getProject()->getProperty('project.dir.behat');
    file_put_contents($dir .'/.gitignore', 'test');
    mkdir($dir . '/features');
    mkdir($dir . '/bootstrap');
    file_put_contents($dir .'/features/test.feature', 'test');
    file_put_contents($dir .'/bootstrap/FeatureContext.php', 'test');
    $this->executeTarget('setup:behat');
    $this->assertStringEqualsFile($dir . '/.gitignore', 'test');
    $this->assertStringEqualsFile($dir . '/features/test.feature', 'test');
    $this->assertStringEqualsFile($dir . '/bootstrap/FeatureContext.php', 'test');
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