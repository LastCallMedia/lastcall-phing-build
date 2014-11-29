<?php

namespace lastcall\phing\Drush;

use lastcall\phing\Phing\ExecWrapperTask;

class DrushTask extends ExecWrapperTask {

  /**
   * @var string
   */
  protected $executable = 'drush';

  /**
   * @var string
   */
  protected $command;

  /**
   * @var string
   */
  protected $alias;

  /**
   * @var \PhingFile
   */
  protected $root;

  /**
   * @var string
   */
  protected $uri;

  /**
   * @var bool
   */
  protected $verbose;

  /**
   * @var bool
   */
  protected $debug;

  /**
   * @var bool
   */
  protected $simulate;

  /**
   * @var bool
   */
  protected $yes;

  /**
   * @var bool
   */
  protected $no;

  protected $args = array();

  /**
   * Initialize global properties.
   */
  public function init() {
    parent::init();
    if($executable = $this->getProject()->getProperty('drush.executable')) {
      $this->setExecutable($executable);
    }
    if($alias = $this->getProject()->getProperty('drush.alias')) {
      $this->setAlias($alias);
    }
    if($root = $this->getProject()->getProperty('drush.root')) {
      $this->setRoot($root);
    }
    if($uri = $this->getProject()->getProperty('drush.uri')) {
      $this->setUri($uri);
    }
  }

  /**
   * @param string $command
   */
  public function setCommand($command) {
    $this->command = $command;
  }

  /**
   * @param string $arg
   */
  public function createArg() {
    return $this->args[] = new DrushArg();
  }

  /**
   * @param string $alias
   */
  public function setAlias($alias) {
    $this->alias = $alias;
  }

  /**
   * @param boolean $debug
   */
  public function setDebug($debug) {
    $this->debug = $debug;
  }

  /**
   * @param mixed $no
   */
  public function setNo($no) {
    $this->no = $no;
  }

  /**
   * @param \PhingFile $root
   */
  public function setRoot($root) {
    $this->root = $root;
  }

  /**
   * @param boolean $simulate
   */
  public function setSimulate($simulate) {
    $this->simulate = $simulate;
  }

  /**
   * @param string $uri
   */
  public function setUri($uri) {
    $this->uri = $uri;
  }

  /**
   * @param boolean $verbose
   */
  public function setVerbose($verbose) {
    $this->verbose = $verbose;
  }

  /**
   * @param boolean $yes
   */
  public function setYes($yes) {
    $this->yes = $yes;
  }

  protected function configureExecTask(\ExecTask $exec) {
    if($this->alias) {
      $exec->createArg()->setValue('@' . $this->alias);
    }
    if($this->command) {
      $exec->createArg()->setValue($this->command);
    }
    if($this->args) {
      foreach($this->args as $arg) {
        $exec->createArg()->setValue($arg);
      }
    }
    if($this->root) {
      $exec->createArg()->setValue('--root=' . $this->root);
    }

    if($this->uri) {
      $exec->createArg()->setValue('--uri=' . $this->uri);
    }

    if($this->verbose) {
      $exec->createArg()->setValue('--verbose');
    }

    if($this->simulate) {
      $exec->createArg()->setValue('--simulate');
    }

    if($this->debug) {
      $exec->createArg()->setValue('--debug');
    }

    if($this->no) {
      $exec->createArg()->setValue('--no');
    }

    if($this->yes) {
      $exec->createArg()->setValue('--yes');
    }

    return $exec;
  }
}