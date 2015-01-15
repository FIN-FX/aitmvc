<?php

namespace Core;

use \Common\Router as Router;

/**
 * Main Model class
 *
 * @author Igor Franzhev :: ifranzhev@gmail.com
 */
class Model
{

  /**
   * Singleton instance
   */
  protected static $instance;

  /**
   * Singleton Factory method.
   * 
   * @return the Singleton instance of Model
   */
  public static function getInstance()
  {
    if (is_null(self::$instance)) 
      self::$instance = new self();
    return self::$instance;
  }

  /**
   * Load all models from models' dir
   */
  function initModels()
  {
    $dirname = Router::getAppPath().'/models/';
    if ($handle = opendir($dirname)) 
    {
      while (false !== ($entry = readdir($handle))) 
      {
        if (strlen($entry) > 2)
          require_once $dirname.$entry;
      }
      closedir($handle);
    }
  }
}