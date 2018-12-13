<?php
/**
 * Created by PhpStorm.
 * User: Swar
 * Date: 12/3/2018
 * Time: 2:09 PM
 */

namespace System\Http;


class Request
{
  private $url;
  private $baseUrl;

  /**
   * @return mixed
   */
  public function prepareUrl()
  {
    $script = dirname($this->server('SCRIPT_NAME'));
    $requestUri = $this->server('REQUEST_URI');
    if (strpos($requestUri, '?') !== false)
      list($requestUri, $queryString) = explode($requestUri, '?');
    $this->url = preg_replace('#^' . $script . '#', '', $requestUri);
    $this->baseUrl = $this->server('REQUEST_SCHEME') . '://' . $this->server('HTTP_HOST') . $script.'/';
  }

  public function server($key, $default = null)
  {
    return key_exists($key, $_SERVER) ? $_SERVER[$key] : $default;
  }

  public function get($key, $default = null)
  {
    return key_exists($key, $_GET) ? $_GET[$key] : $default;
  }

  public function post($key, $default = null)
  {
    return key_exists($key, $_POST) ? $_POST[$key] : $default;
  }

  public function url()
  {
    return $this->url;
  }

  public function baseUrl()
  {
    return $this->baseUrl;
  }

  public function method()
  {
    return $this->server('REQUEST_METHOD');
  }
}