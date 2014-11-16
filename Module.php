<?php
namespace amstr1k\geography;

use Yii;
use yii\base\ErrorException;

class Module extends \yii\base\Module
{
  function init()
  {
    parent::init();

    if(!extension_loaded('zlib'))
    {
      throw new ErrorException("For work module must install `zlib` extension");
      exit;
    }
  }
}