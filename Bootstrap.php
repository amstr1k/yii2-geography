<?php

namespace amstr1k\geography;

use yii\base\BootstrapInterface;

/**
 * Geography module bootstrap class.
 */
class Bootstrap implements BootstrapInterface
{
  /**
   * @inheritdoc
   */
  public function bootstrap($app)
  {
    // Add module I18N category.
    if (!isset($app->i18n->translations['geography']) && !isset($app->i18n->translations['geography*'])) {
      $app->i18n->translations['geography'] = [
        'class'            => 'yii\i18n\PhpMessageSource',
        'basePath'         => '@amstr1k/geography/messages',
        'forceTranslation' => true
      ];
    }
  }
}