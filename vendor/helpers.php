<?php
/**
 * Created by PhpStorm.
 * User: Swar
 * Date: 12/2/2018
 * Time: 6:07 PM
 */
if (!function_exists('pre')) {
  function pre($var)
  {
    echo "<pre>";
    print_r($var);
    echo "</pre>";

  }
}