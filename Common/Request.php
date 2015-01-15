<?php

namespace Common;

/**
 * Class contains attributes and methods 
 * that are the object of the received request
 *
 * @author Igor Franzhev :: ifranzhev@gmail.com
 */
class Request
{
  /**
   * HTTP request type
   */
  private $method;

  /**
   * Name of controller
   */
  private $controller;

  /**
   * Name of action
   */
  private $action;

  /**
   * Request parameters
   */
  private $params;

  /**
   * Singleton instance
   */
  protected static $instance;

  function __construct()
  {
    $path = substr($_SERVER['REQUEST_URI'], 1);
    list($controller, $action) = explode('/', $path);
    
    if (!empty($_POST))
    {
      $method = 'POST';
      $params = $_POST;
    }
    else
    {
      $method = 'GET';
      $params = str_replace("$controller/$action/", '', $path);
      $params = explode('/', $params);
      if (count($params) == 1)
      {
        $params = ['id' => $params[0]];
      }
      else
      {
        $paramsCopy = $params;
        $params = [];
        foreach(range(0, count($paramsCopy), 2) as $num)
        {
          if (empty($paramsCopy[$num]))
            break;
          $params[$paramsCopy[$num]] = (isset($paramsCopy[$num + 1])) ? $paramsCopy[$num + 1] : null;
        }
      }
    }

    if (!empty($method) && !empty($path))
    {
      $this->method = $method;
      $this->controller = $controller;
      $this->action = $action;
      $this->params = $params;
    }
    else
    {
      throw new HttpException(400, 'Bad Request');
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

  function getMethod()
  {
    return strtolower($this->method);
  }

  function getController()
  {
    return $this->controller;
  }

  function getAction()
  {
    return $this->action;
  }

  function getParams()
  {
    return $this->params;
  }
}