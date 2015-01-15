<?php

namespace Common;

/**
 * Dispatcher uses the information from 
 * the Routing step to actually generate the resource
 * 
 * @author Igor Franzhev :: ifranzhev@gmail.com
 */
class Dispatcher
{
  /**
   * Router instance
   */
  private $router;
  
  /** 
   * Singleton instance
   */
  protected static $instance;

  function __construct(\Common\Router $router)
  {
    if (!empty($router))
    {
      $this->router = $router;
    }
    else
    {
      throw new HttpException(500, 'Empty Router object');
    }
  }

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
   * Dispatcher main method to call an action of 
   * controller
   */
  function handle()
  {
    $request = Request::getInstance();
    $handler = $this->router->match($request);
    if (!$handler)
      throw new HttpException(500, 'Invalid handler for request');

    $actionName = 'action'.ucfirst(strtolower($request->getAction()));
    $controller = \Core\Controller::getInstance();
    call_user_func_array(
      [
        $controller, 
        'getAction'
      ], 
      [
        'controllerName' => $request->getController(),
        'actionName' => $actionName, 
        'params' => $request->getParams()
      ]
    );
  }
}