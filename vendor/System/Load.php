<?php
/**
 * Created by PhpStorm.
 * User: Swar
 * Date: 12/5/2018
 * Time: 10:59 AM
 */

namespace System;


class Load
{
  private $app;
  private $controllers = [];
  private $models = [];

  public function __construct(Application $app)
  {

    $this->app = $app;
  }

  /**
   * Call the given controller with the given method
   * and pass the given arguments to the controller method
   * @param $controller
   * @param $method
   * @param $arguments
   */
  public function action($controller, $method, $arguments)
  {
    $object = $this->controller($controller);
    return call_user_func([$object, $method], $arguments);
  }

  /**
   * call the given controller
   * @param $controller
   * @return object
   */
  public function controller($controller)
  {
    $controller = $this->getControllerName($controller);
    if (!$this->hasController($controller)) {
      $this->addController($controller);
    }
    return $this->getController($controller);
  }

  private function getControllerName($controller)
  {
    $controller .= 'Controller';
    $controller = 'App\\Controllers\\' . $controller;
    return str_replace('/', '\\', $controller);
  }

  /**
   * @param $controller
   * @return bool
   */
  private function hasController($controller)
  {
    return key_exists($controller, $this->controllers);
  }

  /**
   * create new object for the given controller and store it in controller container
   * @param $controller
   * @return void
   */
  private function addController($controller)
  {
    $object = new $controller($this->app);
    $this->controllers[$controller] = $object;
  }

  /**
   * @param $controller
   * @return object
   */
  private function getController($controller)
  {
    return $this->controllers[$controller];
  }
}