<?php

namespace Core;

class Controller implements \Interfaces\IController
{
  function __construct()
  {

  }

  function actionAddress($id)
  {
    var_dump($id);
    die();
  }
}