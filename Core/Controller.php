<?php

namespace Core;

use \Common\Router as Router;

/**
 * Main Controller class which manages
 * views, models and actions
 *
 * @author Igor Franzhev :: ifranzhev@gmail.com
 */
class Controller
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
   * Method inits model's classes and 
   * calls actions of developer controllers
   * 
   * @param string $controllerName controller to call
   * @param string $actionName action to call
   * @param array $params array of parameters
   */
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