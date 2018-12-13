<?php
/**
 * Created by PhpStorm.
 * User: Swar
 * Date: 12/13/2018
 * Time: 12:11 PM
 */

namespace System\Http;

use System\Application;

class Response
{
  private $app;
  /**
   * header container that will be sent to the browser
   * @var array
   */
  private $headers = [];
  private $content;

  /**
   * Response constructor.
   * @param Application $app
   */
  public function __construct(Application $app)
  {
    $this->app = $app;
  }

  /**
   * @param $content
   */
  public function setOutput($content)
  {
    $this->content = $content;
  }

  /**
   * set the response header
   * @param $header
   * @param $value
   */
  public function setHeaders($header, $value)
  {
    $this->headers[$header] = $value;
  }

  public function send()
  {
    $this->sendHeaders();
    $this->sendOutput();
  }

  private function sendHeaders()
  {
    foreach ($this->headers as $header => $value) {
      header($header . ':' . $value);
    }
  }

  /**
   * send response output
   * @return void
   */
  private function sendOutput()
  {
    echo $this->content;
  }
}