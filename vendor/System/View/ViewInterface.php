<?php
/**
 * Created by PhpStorm.
 * User: Swar
 * Date: 12/13/2018
 * Time: 10:45 AM
 */

namespace System\View;

interface ViewInterface
{
  /**
   * get the view output
   * @return string
   */
  public function getOutput();

  /**
   * convert the view object to string in printing
   * echo $object
   * @return string
   */
  public function __toString();

}