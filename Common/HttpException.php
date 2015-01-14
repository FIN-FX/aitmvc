<?php

namespace Common;

class HttpException implements \Interfaces\IHttpException
{
  private $statusCode;
  private $error;

  function __construct($statusCode, $error)
  {
    if (!empty($statusCode) && !empty($error))
    {
      $this->statusCode = $statusCode;
      $this->error = $error;
    }
    else
    {
      throw new \Exception('Empty HTTP exception');
    }
  }

  public function getStatusCode()
  {

  }

  public function getError()
  {

  }
}