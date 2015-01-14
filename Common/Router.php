<?php

namespace Common;

class Router
{
  private $routes = [
    'get' => [],
    'post' => []
  ];

  function get($pattern, callable $handler)
  {
    $this->routes['get'][$pattern] = $handler;
    return $this;
  }

  function post($pattern, callable $handler)
  {
    $this->routes['post'][$pattern] = $handler;
    return $this;
  }

  function match(Request $request)
  {
    $method = $request->getMethod();
    $path = $request->getPath();
    if (!empty($this->routes[$method]))
    {
      foreach($this->routes[$method] as $pattern => $handler)
      {
        if ($pattern === $path)
        {
          return $handler;
        }
      }
    }
    return false;
  }
}