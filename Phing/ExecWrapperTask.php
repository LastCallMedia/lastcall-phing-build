<?php

namespace lastcall\phing\Phing;

use Target;

abstract class ExecWrapperTask extends \Task {

  /**
   * @var string
   */
  protected $executable;

  /**
   * @var \ExecTask
   */
  protected $execTask;


  /**
   * @var \PhingFile
   */
  protected $dir;

  public function __construct() {
    $this->execTask = new EnhancedExecTask();
    $this->execTask->setExecutable(new \PhingFile($this->executable));
  }

  public function setProject(\Project $project){
    parent::setProject($project);
    $this->execTask->setProject($project);
  }

  public function setOwningTarget(\Target $target) {
    parent::setOwningTarget($target);
    $this->execTask->setOwningTarget($target);
  }

  public function init() {
    parent::init();
    $this->execTask->init();
  }

  /**
   * @param boolean $checkreturn
   */
  public function setCheckreturn($checkreturn) {
    $this->execTask->setCheckreturn($checkreturn);
  }

  /**
   * @param \PhingFile $dir
   */
  public function setDir(\PhingFile $dir) {
    $this->execTask->setDir($dir);
  }

  /**
   * @param string $executable
   */
  public function setExecutable($executable) {
    $this->execTask->setExecutable(new \PhingFile($executable));
  }

  /**
   * @param \PhingFile $output
   */
  public function setOutput(\PhingFile $output) {
    $this->execTask->setOutput($output);
  }

  /**
   * @param string $outputProperty
   */
  public function setOutputProperty($prop) {
    $this->execTask->setOutputProperty($prop);
  }

  /**
   * @param boolean $passthru
   */
  public function setPassthru($passthru) {
    $this->execTask->setPassthru($passthru);
  }

  public function setReturnProperty($prop) {
    $this->execTask->setReturnProperty($prop);
  }

  public function maybeConfigure() {
    parent::maybeConfigure();
    $this->execTask->maybeConfigure();
  }

  public function main() {
    return $this->getExecTask()->main();
  }

  /**
   * @return \ExecTask
   */
  public function getExecTask() {
    return $this->configureExecTask(clone $this->execTask);
  }

  abstract protected function configureExecTask(\ExecTask $exec);
}