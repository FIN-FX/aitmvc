<?php

namespace Common;

class HttpException extends \Exception
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

  function render()
  {
    $data = [
      'status' => $this->statusCode,
      'msg' => $this->error
    ];

    $view = \Core\View::getInstance();
    $view->setRenderType('html');
    $view->setTemplate('error');
    if ($view->checkTemplate())
      $view->render($data);
    else
      echo 'An error has occured. Check error template is exist.';
  }
}