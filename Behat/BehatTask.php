<?php

namespace lastcall\Phing\Behat;

use lastcall\Phing\Phing\ExecWrapperTask;

class BehatTask extends ExecWrapperTask {

  /**
   * @var string  The path to the behat executable.
   */
  protected $executable = 'behat';

  /**
   * @var \PhingFile  The behat.yml to use.
   */
  protected $config;

  /**
   * @var string  The output formatter to use.
   */
  protected $format;

  /**
   * @var string  The output file to use.
   */
  protected $out;

  /**
   * @var string The profile to use.
   */
  protected $profile;

  /**
   * @var bool  Whether to add the --no-colors option.
   */
  protected $nocolors;

  /**
   * @var string  Definitions to print out.
   */
  protected $definitions;

  public function init() {
    parent::init();
    if($executable = $this->getProject()->getProperty('behat.executable')) {
      $this->setExecutable($executable);
    }
    if($config = $this->getProject()->getProperty('behat.config')) {
      $this->setConfig(new \PhingFile($config));
    }
  }

  public function setConfig(\PhingFile $config) {
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

  public function setNocolors($nocolors) {
    $this->nocolors = (bool) $nocolors;
  }

  public function setOutput(\PhingFile $file) {
    $this->output = $file;
  }

  public function setDefinitions($definitions) {
    $this->definitions = $definitions;
  }


  protected function configureExecTask(\ExecTask $exec) {
    if($this->config) {
      $arg = $exec->createArg();
      $arg->setValue('--config');
      $arg = $exec->createArg();
      $arg->setFile($this->config);
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
    if($this->definitions) {
      $exec->createArg()->setValue('--definitions=' . $this->definitions);
    }
    if($this->definitions) {
      $exec->createArg()->setValue('--definitions=' . $this->definitions);
    }

    if($this->output) {
      $exec->setOutput($this->output);
    }

    if($this->nocolors) {
      $exec->createArg()->setValue('--no-colors');
    }
    return $exec;
  }
}