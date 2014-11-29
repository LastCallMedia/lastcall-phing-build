<?php

namespace lastcall\phing\Tests\Phing;

use lastcall\phing\Phing\ExecWrapperTask;

abstract class BaseTaskTest extends \BuildFileTest {

  protected $taskFile;

  /**
   * @var \Project
   */
  protected $project;

  public function setUp() {
    $this->configureProject($this->getTaskFile());
  }

  abstract function getTaskFile();

  public function optionTaskProvider() {
    $p = new \Project();
    $p->init();
    $f = new \PhingFile($this->getTaskFile());
    $p->setUserProperty("phing.file", $f->getAbsolutePath());
    $p->setUserProperty("phing.dir", dirname($f->getAbsolutePath()));
    \ProjectConfigurator::configureProject($p, new \PhingFile($this->getTaskFile()));

    $options = array();
    /** @var \Target $target */
    foreach($p->getTargets() as $target) {
      $name = $target->getName();
      if(!empty($name)) {
        $expected = preg_replace_callback('/\[\[(.*)\]\]/', array($this, 'makePathAbsolute'), $target->getDescription());
        $options[$target->getName()] = array($target->getName(), $expected);
      }
    }
    return $options;
  }

  public function makePathAbsolute($path) {
    $phingfile = new \PhingFile($this->getTaskFile());
    return dirname($phingfile->getCanonicalPath()) . '/' . $path[1];
  }

  protected function getCommandExecutedByTarget($target_name) {
    $execExtensionTask = $this->getConfiguredTask($target_name, 'behat');

    if ($execExtensionTask instanceof \UnknownElement) {
      $execExtensionTask = $execExtensionTask->getRuntimeConfigurableWrapper()->getProxy();
    }
    if(!$execExtensionTask instanceof ExecWrapperTask) {
      throw new \Exception('Task is not an ExecExtensionTask: ' . $execExtensionTask->getTaskName());
    }

    /** @var \ExecTask $execTask */
    $execTask = $execExtensionTask->getExecTask();
    $reflec = new \ReflectionObject($execTask);
    $meth = $reflec->getMethod('buildCommand');
    $meth->setAccessible(TRUE);
    $meth->invoke($execTask);
    $prop = $reflec->getProperty('realCommand');
    $prop->setAccessible(TRUE);
    return $prop->getValue($execTask);
  }

  protected function getExpectedByTarget($target_name) {
    $echoTask = $this->getConfiguredTask($target_name, 'Task', 1);
    if ($echoTask instanceof \UnknownElement) {
      $echoTask = $echoTask->getRuntimeConfigurableWrapper()->getProxy();
    }
    if(!$echoTask instanceof \EchoTask) {
      throw new \Exception('Task is not an EchoTask: ' . $echoTask->getTaskName());
    }
    $reflec = new \ReflectionObject($echoTask);
    $prop = $reflec->getProperty('msg');
    $prop->setAccessible(TRUE);
    return $prop->getValue($echoTask);
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