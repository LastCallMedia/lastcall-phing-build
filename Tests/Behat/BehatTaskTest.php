<?php

namespace lastcall\Phing\Tests\Behat;


class BehatTaskTest extends \BuildFileTest {

  /**
   * @var \Project
   */
  protected $project;

  protected function setUp() {
    $this->configureProject(__DIR__ . '/Resources/build.xml');
  }

  public function testExecutable() {
    $this->assertEquals('bin/behat', $this->getCommandExecutedByTarget(__FUNCTION__));
  }

  public function testPassthru() {
    $this->assertEquals('bin/behat 2>&1', $this->getCommandExecutedByTarget(__FUNCTION__));
  }

  public function testConfig() {
    $expected = realpath(__DIR__ . '/Resources/behat.yml');
    $this->assertEquals('bin/behat --config ' . $expected, $this->getCommandExecutedByTarget(__FUNCTION__));
  }

  public function testFormat() {
    $this->assertEquals('bin/behat --format=pretty', $this->getCommandExecutedByTarget(__FUNCTION__));
  }

  public function testOut() {
    $this->assertEquals('bin/behat --out=test.log --no-colors', $this->getCommandExecutedByTarget(__FUNCTION__));
  }

  public function testProfile() {
    $this->assertEquals('bin/behat --profile=test', $this->getCommandExecutedByTarget(__FUNCTION__));
  }

  public function testNoColors() {
    $this->assertEquals('bin/behat --no-colors', $this->getCommandExecutedByTarget(__FUNCTION__));
  }

  protected function getCommandExecutedByTarget($target_name) {
    $task = $this->getConfiguredTask($target_name, 'behat');

    if ($task instanceof \UnknownElement) {
      $task = $task->getRuntimeConfigurableWrapper()->getProxy();
    }

    /** @var \ExecTask $exec */
    $exec = $task->getExecTask();
    $exec_reflec = new \ReflectionObject($exec);
    $meth = $exec_reflec->getMethod('buildCommand');
    $meth->setAccessible(TRUE);
    $meth->invoke($exec);
    $prop = $exec_reflec->getProperty('realCommand');
    $prop->setAccessible(TRUE);
    return $prop->getValue($exec);
  }

  protected function getTargetByName($name)
  {
    foreach ($this->project->getTargets() as $target) {
      if ($target->getName() == $name) {
        return $target;
      }
    }
    throw new \Exception(sprintf('Target "%s" not found', $name));
  }

  protected function getTaskFromTarget($target, $taskname, $pos = 0)
  {
    $rchildren = new \ReflectionProperty(get_class($target), 'children');
    $rchildren->setAccessible(true);
    $n = -1;
    foreach ($rchildren->getValue($target) as $child) {
      if ($child instanceof \Task && ++$n == $pos) {
        return $child;
      }
    }
    throw new \Exception(
      sprintf('%s #%d not found in task', $taskname, $pos)
    );
  }

  protected function getConfiguredTask($target, $task, $pos = 0)
  {
    $target = $this->getTargetByName($target);
    $task = $this->getTaskFromTarget($target, $task);
    $task->maybeConfigure();
    return $task;
  }

}