<?php
/**
 * Created by PhpStorm.
 * User: Swar
 * Date: 12/4/2018
 * Time: 5:18 PM
 */

namespace System;


class Route
{
  private $app;
  private $notFound;
  private $routes = [];

  public function __construct(Application $app)
  {
    $this->app = $app;
  }

  /**
   * @param $url
   * @param $action
   * @param string $requestMethod
   */
  public function add($url, $action, $requestMethod = 'GET')
  {
    $this->routes[] = [
      'url' => $url,
      'pattern' => $this->generatePattern($url),
      'action' => $this->getAction($action),
      'method' => strtolower($requestMethod),
    ];
  }

  /**
   * @param $url
   * @return string
   */
  private function generatePattern($url)
  {
//    echo "<pre>";var_dump($url);die;
    $pattern = '#^';
    $pattern .= str_replace(
      [':text', ':id'], ['([a-zA-Z0-9-]+)', '(\d+)'], $url
    );
    $pattern .= '$#';
//    echo "<pre>";print_r($pattern);die;
    return $pattern;
  }

  private function getAction($action)
  {

    $action = str_replace('/', '\\', $action);

    return strpos($action, '@') !== false ? $action : $action . '@index';
  }

  /**
   * @param $url
   */
  public function notFound($url)
  {
    $this->notFound = $url;
  }

  /**
   *
   */
  public function getProperRoute()
  {
    foreach ($this->routes as $route) {
      if ($this->isMatching($route['pattern'])) {
        $arguments = $this->getArgumentsFrom($route['pattern']);
        list($controller, $method) = explode('@', $route['action']);
        return [$controller, $method, $arguments];
      }
    }
  }

  /**
   * Determine if the given pattern matches the current request url
   * @param string $pattern
   * @return bool
   */
  private function isMatching($pattern)
  {
    return preg_match($pattern, $this->app->request->url());
  }

  /**
   * Get Arguments from the current request url
   * based on the given pattern
   * @param string $pattern
   * @return array
   */
  private function getArgumentsFrom($pattern)
  {
    preg_match($pattern, $this->app->request->url(), $matches);
    array_shift($matches);
    return $matches;
  }
}