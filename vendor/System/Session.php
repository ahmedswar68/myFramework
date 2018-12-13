<?php
/**
 * Created by PhpStorm.
 * User: Swar
 * Date: 12/3/2018
 * Time: 10:50 AM
 */

namespace System;


class Session
{
  private $app;

  public function __construct(Application $app)
  {
    $this->app = $app;
  }

  public function start()
  {
    ini_set('session.use_only_cookies', 1);
    if (!session_id())
      session_start();
  }

  public function set($key, $value)
  {
    $_SESSION[$key] = $value;
  }

  public function has($key)
  {
    return isset($_SESSION[$key]);
  }

  public function all()
  {
    return $_SESSION;
  }

  public function pull($key)
  {
    $value = $this->get($key);
    $this->remove($key);
    return $value;
  }

  public function get($key)
  {
    return key_exists($key, $_SESSION) ? $_SESSION[$key] : null;
  }

  public function remove($key)
  {
    unset($_SESSION[$key]);
  }

  public function destroy()
  {
    session_destroy();
    unset($_SESSION);
  }
}