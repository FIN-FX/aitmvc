<?php

namespace Core;

use \Common\Router as Router;

/**
 * Main View class which checks
 * and render templates
 *
 * @author Igor Franzhev :: ifranzhev@gmail.com
 */
class View
{
  /**
   * Type of rendering (html, json)
   */
  private $renderType;

  /**
   * Rendering template
   */
  private $template;

  /**
   * Singleton instance
   */
  protected static $instance;

  function __construct()
  {
    $this->template = strtolower(str_replace('action', '', debug_backtrace()[1]['function']));
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

  function setRenderType($renderType)
  {
    if (!empty($renderType))
      $this->renderType = $renderType;
  }

  function setTemplate($templateName)
  {
    $this->template = $templateName;
  }

  /**
   * Checks if template exists
   */
  function checkTemplate()
  {
    $filename = Router::getAppPath().'/views/'.$this->template.'.html';
    if (file_exists($filename))
      return $filename;
    return false;
  }

  /**
   * Renders template with current
   * parameters
   *
   * @param array $params
   */
  function render($params)
  {
    switch($this->renderType)
    {
      case 'html':
        if (($filename = $this->checkTemplate()))
        {
          $content = file_get_contents($filename);
          foreach($params as $name => $val)
            $content = str_replace('{{'.$name.'}}', $val, $content);
          echo $content;
        }
        else
        {
          throw new \Common\HttpException(500, 'Template does not exist. Please create it in views folder.');
        }
        break;
      default:
        echo json_encode($params);
    }
  }
}