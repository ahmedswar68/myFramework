<?php
/**
 * Created by PhpStorm.
 * User: Swar
 * Date: 12/13/2018
 * Time: 10:45 AM
 */

namespace System\View;

use System\Application;

class ViewFactory
{
  private $app;

  public function __construct(Application $app)
  {
    $this->app = $app;
  }

  /**
   * Render the given view path with the passed variable
   * @param $viewPath
   * @param array $data
   * @return \System\View\ViewInterface
   */
  public function render($viewPath, $data = [])
  {
    return new View($this->app->file, $viewPath, $data);
  }
}