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
    if (!isset($app->i18n->translations['amstr1k/geography']) && !isset($app->i18n->translations['amstr1k/*'])) {
      $app->i18n->translations['amstr1k/geography'] = [
        'class'            => 'yii\i18n\PhpMessageSource',
        'basePath'         => '@amstr1k/geography/messages',
        'forceTranslation' => true,
        'fileMap' => [
          'amstr1k/geography' => 'geography.php',
        ]
      ];
    }
  }
}