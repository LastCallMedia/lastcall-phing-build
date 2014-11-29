<?php

namespace lastcall\phing\Phing;

class EnhancedExecTask extends \ExecTask {

  /**
   * {@inheritdoc}
   * Overridden cleanup to throw a more useful error message.
   */
  protected function cleanup($return, $output)
  {
    try {
      parent::cleanup($return, $output);
    }
    catch(\BuildException $e) {
      $message = implode("\n", $output);
      throw new \BuildException("Task exited with code $return. Output follows:\n$message");
    }
  }
}