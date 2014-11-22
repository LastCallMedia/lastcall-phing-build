<?php

namespace lastcall\Phing\Behat;

class BehatTask extends \Task {

  /**
   * @var string  The path to the behat executable.
   */
  private $executable = 'behat';

  /**
   * @var string  The behat.yml to use.
   */
  private $config;

  /**
   * @var string  The output formatter to use.
   */
  private $format;

  /**
   * @var string  The output file to use.
   */
  private $out;

  /**
   * @var string The profile to use.
   */
  private $profile;

  /**
   * @var string The base URL to use.
   */
  private $base_url;

  /**
   * @var bool  Whether to add the --no-colors option.
   */
  private $nocolors;

  /**
   * @var bool Whether to print output.
   */
  private $passthru = TRUE;

  /**
   * @var string  Definitions to print out.
   */
  private $definitions;

  public function main() {
    $exec = $this->getExecTask();

    return $exec->main();
  }

  public function setExecutable($executable) {
    $this->executable = $executable;
  }

  public function setConfig($config) {
    $this->config = $config;
  }

  public function setFormat($format) {
    $this->format = $format;
  }

  public function setOut($out) {
    $this->out = $out;
  }

  public function setProfile($profile) {
    $this->profile = $profile;
  }

  public function setBase_Url($base_url) {
    $this->base_url = $base_url;
  }

  public function setNocolors($nocolors) {
    $this->nocolors = (bool) $nocolors;
  }

  public function setPassthru($passthru) {
    $this->passthru = (bool) $passthru;
  }

  public function setDefinitions($definitions) {
    $this->definitions = $definitions;
  }

  /**
   * @return \ExecTask
   */
  public function getExecTask() {
    $exec = new \ExecTask();
    $exec->setProject($this->getProject());
    $exec->init();

    $executable = $this->executable;
    $exec->setExecutable($executable);
    $exec->setPassthru($this->passthru);
    $exec->setCheckreturn(TRUE);

    if($this->config) {
      $arg = $exec->createArg();
      $arg->setValue('--config');
      $arg = $exec->createArg();
      $arg->setFile(new \PhingFile($this->config));
    }

    if($this->format) {
      $arg = $exec->createArg();
      $arg->setValue('--format=' . $this->format);
    }

    if($this->out) {
      $exec->createArg()
        ->setValue('--out=' . $this->out);
      $this->nocolors = TRUE;
    }

    if($this->profile) {
      $exec->createArg()
        ->setValue('--profile=' . $this->profile);
    }

    if($this->base_url) {
//      $exec->setOwningTarget();
    }

    if($this->definitions) {
      $exec->createArg()->setValue('--definitions=' . $this->definitions);
    }

    if($this->nocolors) {
      $exec->createArg()->setValue('--no-colors');
    }

    return $exec;
  }

}