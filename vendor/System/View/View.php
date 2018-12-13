<?php
/**
 * Created by PhpStorm.
 * User: Swar
 * Date: 12/13/2018
 * Time: 10:45 AM
 */

namespace System\View;

use System\File;

class View implements ViewInterface
{
  private $file;
  private $viewPath;
  private $data = [];
  private $output;

  /**
   * View constructor.
   * @param File $file
   * @param $viewPath
   * @param array $data
   */
  public function __construct(File $file, $viewPath, $data = [])
  {
    $this->file = $file;
    $this->preparePath($viewPath);
    $this->data = $data;
  }

  /**
   * @param $viewPath
   */
  private function preparePath($viewPath)
  {
    $relativeViewPath = 'App/Views/' . $viewPath . '.php';
    $this->viewPath = $this->file->to($relativeViewPath);
    if (!$this->viewFileExists($relativeViewPath)) {
      die("$viewPath does not exist in the Views Directory");
    }
  }

  private function viewFileExists($viewPath)
  {
    return $this->file->exists($viewPath);
  }

  public function __toString()
  {
    return $this->getOutput();
  }

  public function getOutput()
  {
    if (is_null($this->output)) {
      ob_start();
      extract($this->data);
      require $this->viewPath;
      $this->output = ob_get_clean();
    }
    return $this->output;
  }
}