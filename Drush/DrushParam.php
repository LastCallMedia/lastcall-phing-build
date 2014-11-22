<?php

namespace lastcall\Phing\Drush;

/**
 * A Drush CLI parameter.
 */
class DrushParam {

  /**
   * @var string The parameter's value.
   */
  protected $value;

  /**
   * Set the parameter value from a text element.
   *
   * @param mixed $str
   *   The value of the text element.
   */
  public function addText($str) {
    $this->value = (string) $str;
  }

  /**
   * Get the parameter's value.
   *
   * return string
   *   The parameter value.
   */
  public function getValue() {
    return $this->value;
  }

}