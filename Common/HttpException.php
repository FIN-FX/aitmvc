<?php

namespace Common;

/**
 * Custom Exception handler which generates
 * an HTML page with error description
 *
 * @author Igor Franzhev :: ifranzhev@gmail.com
 */
class HttpException extends \Exception
{
  /**
   * Code of error
   */
  private $statusCode;

  /**
   * Error description
   */
  private $error;

  /**
   * Constructor
   * 
   * @param integer $statusCode code of error
   * @param string $error error description
   */
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

  /**
   * Method renders error template 
   * with description
   */
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