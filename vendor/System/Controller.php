<?php
/**
 * Created by PhpStorm.
 * User: Swar
 * Date: 12/13/2018
 * Time: 11:23 AM
 */

namespace System;

abstract class Controller
{
  private $app;

  public function __construct(Application $app)
  {
    $this->app = $app;
  }

  public function __get($key)
  {
    return $this->app->get($key);
  }
}