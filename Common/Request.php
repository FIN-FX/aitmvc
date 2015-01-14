<?php

namespace Common;

class Request
{
  private $method;
  private $path;

  function __construct($method, $path)
  {
    if (!empty($method) && !empty($path))
    {
      $this->method = $method;
      $this->path = $path;
    }
    else
    {
      throw new HttpException(400, 'Bad Request');
    }
  }

  function getMethod()
  {
    return strtolower($this->method);
  }

  function getPath()
  {
    return $this->path;
  }
}