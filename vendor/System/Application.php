<?php
/**
 * Created by PhpStorm.
 * User: Swar
 * Date: 12/2/2018
 * Time: 5:22 PM
 */

namespace System;
class Application
{
  private static $instance;
  /**
   * Container
   * @var array
   */
  private $container = [];

  /**
   * Constructor
   * @param \System\File $file
   */
  private function __construct(File $file)
  {
    $this->share('file', $file);
    $this->registerClasses('file', $file);
    $this->loadHelpers();
  }

  /**
   * @param $key
   * @param $value
   * share the given key and value
   */
  public function share($key, $value)
  {
    $this->container[$key] = $value;
  }

  /**
   * Register classes in spl autoload register
   * @return void
   */
  private function registerClasses()
  {
    //load is a callback function and it must be a public function
    spl_autoload_register([$this, 'load']);
  }

  private function loadHelpers()
  {
    $this->file->requires('vendor/helpers.php');
  }

  public static function getInstance($file = null)
  {
    if (is_null(static::$instance)) {
      static::$instance = new static($file);
    }
    return static::$instance;
  }

  /**
   * @return void
   */
  public function run()
  {
    $this->session->start();
    $this->request->prepareUrl();
    $this->file->requires('App/index.php');
    list($controller, $method, $arguments) = $this->route->getProperRoute();
    $output = (string)$this->load->action($controller, $method, $arguments);
    $this->response->setOutput($output);
    $this->response->send();
  }

  /**
   * load class through autoloading
   * @param strin $class
   * return void
   */
  public function load($class)
  {

    if (strpos($class, 'App') === 0) {
      $file = $class . '.php';
    } else {
      $file = 'vendor/' . $class . '.php';
    }
    if ($this->file->exists($file)) {
      $this->file->requires($file);
    }

  }

  /**
   * get shared value dynamically
   * @param $key
   * @return mixed
   */
  public function __get($key)
  {
    return $this->get($key);
  }

  /**
   * Get Shared Value
   * @param string $key
   * @return mixed
   */
  public function get($key)
  {
    if (!$this->isSharing($key)) {
      if ($this->isCoreAlias($key)) {
        $this->share($key, $this->createNewCoreObject($key));
      } else {
        die("$key not found in Application Container");
      }
    }
    return $this->container[$key];
  }

  /**
   * @param $key
   * @return bool
   */
  public function isSharing($key)
  {
    return isset($this->container[$key]);
  }

  /**
   * @param $alias
   * @return bool
   */
  private function isCoreAlias($alias)
  {
    $coreClasses = $this->coreClasses();
    return isset($coreClasses[$alias]);
  }

  /**
   * get All core Classes with its aliases
   * @return array
   */
  private function coreClasses()
  {
    return [
      'request' => 'System\\Http\\Request',
      'response' => 'System\\Http\\Response',
      'session' => 'System\\Session',
      'route' => 'System\\Route',
      'cookie' => 'System\\Cookie',
      'load' => 'System\\Loader',
      'html' => 'System\\Html',
      'db' => 'System\\Database',
      'view' => 'System\\View\\ViewFactory',
    ];

  }

  /**
   * @param $alias
   * @return mixed
   */
  private function createNewCoreObject($alias)
  {
    $coreClasses = $this->coreClasses();
    $object = $coreClasses[$alias];
    return new $object($this);
  }
}