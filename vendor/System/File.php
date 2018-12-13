<?php
/**
 * Created by PhpStorm.
 * User: Swar
 * Date: 12/2/2018
 * Time: 5:22 PM
 */

namespace System;
class File
{
  /**
   * @const string
   */
  const DS = DIRECTORY_SEPARATOR;
  /**
   * Root Path
   * @var string
   */
  private $root;

  /**
   * Constructor
   * @param string root
   */
  public function __construct($root)
  {
    $this->root = $root;
  }

  /**
   * Determine the given file path exists or not
   * @param string $file
   * @return boolean
   */
  public function exists($file)
  {
    return file_exists($this->to($file));
  }

  public function to($path)
  {
    return $this->root . static::DS . str_replace(['/', '\\'], static::DS, $path);
  }

  /**
   * Determine the given file path exists or not
   * @param string $file
   * @return boolean
   */
  public function requires($file)
  {
    require $this->to($file);
  }

  /**
   * Geneare full path to the given path in vendor folder
   * @param $path
   * @return string
   */
  public function toVendor($path)
  {
    return $this->to('vendor/' . $path);
  }
}