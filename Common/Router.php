<?php

namespace Common;

class Router
{
  private $routes = [
    'get' => [],
    'post' => []
  ];

  public static $appPath;

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

  static function setAppPath($path)
  {
    self::$appPath = $path;
  }

  static function getAppPath()
  {
    return self::$appPath;
  }

  function registerRouteGet($action)
  {
    $this->routes['get'][$action] = 1;
    return $this;
  }

  function registerRoutePost($action)
  {
    $this->routes['post'][$action] = 1;
    return $this;
  }

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