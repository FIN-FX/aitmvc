<?php

namespace Common;

/**
 * Route a specific request URL to an object and 
 * method that will be invoked to complete the request
 *
 * @author Igor Franzhev :: ifranzhev@gmail.com
 */
class Router
{
  /**
   * Contains existing routes
   */
  private $routes = [
    'get' => [],
    'post' => []
  ];

  /**
   * Contains path to root application folder
   */
  public static $appPath;

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

  static function setAppPath($path)
  {
    self::$appPath = $path;
  }

  static function getAppPath()
  {
    return self::$appPath;
  }

  /**
   * Register new route for GET request
   * 
   * @param string $action URL string
   */
  function registerRouteGet($action)
  {
    $this->routes['get'][$action] = 1;
    return $this;
  }

  /**
   * Register new route for POST request
   *
   * @param string $action URL string
   */
  function registerRoutePost($action)
  {
    $this->routes['post'][$action] = 1;
    return $this;
  }

  /**
   * Check if route exists for current request
   *
   * @param object $request
   */
  function match(\Common\Request $request)
  {
    $method = $request->getMethod();
    $controller = $request->getController();
    $action = $request->getAction();

    if (!empty($this->routes[$method]))
    {
      foreach($this->routes[$method] as $pattern => $handler)
      {
        if ($pattern === "$controller/$action")
        {
          return true;
        }
      }
    }
    return false;
  }
}