<?php

namespace Common;

class Dispatcher
{
  private $router;

  function __construct(\Router\Router $router)
  {
    if (!empty($router))
    {
      $this->router = $router;
    }
    else
    {
      throw new \Exception('Empty Router object');
    }
  }

  function handle(\Request\Request $request)
  {
    $handler = $this->router->match($request);
    if (!$handler)
      throw new \Exception('Invalid handler for request');

    $handler();
  }
}