<?php

namespace lastcall\phing\Drush;


class DrushArg {

  protected $val;

  public function addText($val) {
    $this->val = $val;
  }

  public function __toString() {
    return (string) $this->val;
  }
}