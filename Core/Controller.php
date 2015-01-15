<?php

namespace Core;

use \Common\Router as Router;

class Controller
{
  // Singleton instance
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

  function getAction($controllerName, $actionName, $params)
  {
    $filename = Router::getAppPath().'/controllers/'.ucfirst($controllerName).'Controller.php';
    if (file_exists($filename))
    {
      $model = Model::getInstance();
      $model->initModels();

      require_once $filename;
      $className = '\\'.ucfirst($controllerName).'Controller';
      $controller = new $className();
      call_user_func_array([$controller, $actionName], $params);
    }
    else
    {
      throw new \Common\HttpException(500, 'Create '.$controller.' controller.');
    }
  }

  function getView()
  {
    return View::getInstance();
  }
}