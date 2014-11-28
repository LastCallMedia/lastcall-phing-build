<?php

namespace lastcall\Phing\Phing;

use Target;

abstract class ExecWrapperTask extends \Task {

  /**
   * @var string
   */
  protected $executable;

  /**
   * @var bool
   */
  protected $passthru;

  /**
   * @var \PhingFile
   */
  protected $output;

  /**
   * @var bool
   */
  protected $checkReturn;

  /**
   * @var string
   */
  protected $outputProperty;

  /**
   * @var \PhingFile
   */
  protected $dir;

  /**
   * @param boolean $checkReturn
   */
  public function setCheckReturn($checkReturn) {
    $this->checkReturn = $checkReturn;
  }

  /**
   * @param \PhingFile $dir
   */
  public function setDir($dir) {
    $this->dir = $dir;
  }

  /**
   * @param string $executable
   */
  public function setExecutable($executable) {
    $this->executable = $executable;
  }

  /**
   * @param \PhingFile $output
   */
  public function setOutput($output) {
    $this->output = $output;
  }

  /**
   * @param string $outputProperty
   */
  public function setOutputProperty($outputProperty) {
    $this->outputProperty = $outputProperty;
  }

  /**
   * @param boolean $passthru
   */
  public function setPassthru($passthru) {
    $this->passthru = $passthru;
  }


  public function main() {
    $exec = $this->getExecTask();

    return $exec->main();
  }

  public function getExecTask() {
    $exec = new \ExecTask();
    $exec->setProject($this->getProject());
    $exec->init();

    $exec->setExecutable($this->executable);
    $exec->setPassthru($this->passthru);
    if($this->output) {
      $exec->setOutput($this->output);
    }
    $exec->setCheckreturn($this->checkReturn);
    $exec->setOutputProperty($this->outputProperty);
    if($this->dir) {
      $exec->setDir($this->dir);
    }

    return $this->configureExecTask($exec);
  }

  abstract protected function configureExecTask(\ExecTask $exec);
}