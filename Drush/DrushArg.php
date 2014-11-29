<?php

namespace lastcall\Phing\Drush;


class DrushArg {

  protected $val;

  public function addText($val) {
    $this->val = $val;
  }

  public function __toString() {
    return (string) $this->val;
  }
}