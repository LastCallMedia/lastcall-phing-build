<?php
$vendor_dir = file_exists(__DIR__ . '/../vendor') ?
  __DIR__ .'/../vendor' :
  __DIR__ .'/../..';

require_once $vendor_dir . '/autoload.php';
require_once $vendor_dir . '/phing/phing/test/bootstrap.php';