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

  /**
   * Translates a message to the specified language.
   *
   * This is a shortcut method of [[\yii\i18n\I18N::translate()]].
   *
   * The translation will be conducted according to the message category and the target language will be used.
   *
   * You can add parameters to a translation message that will be substituted with the corresponding value after
   * translation. The format for this is to use curly brackets around the parameter name as you can see in the following example:
   *
   * ```php
   * $username = 'Alexander';
   * echo \Yii::t('app', 'Hello, {username}!', ['username' => $username]);
   * ```
   *
   * Further formatting of message parameters is supported using the [PHP intl extensions](http://www.php.net/manual/en/intro.intl.php)
   * message formatter. See [[\yii\i18n\I18N::translate()]] for more details.
   *
   * @param string $category the message category.
   * @param string $message the message to be translated.
   * @param array $params the parameters that will be used to replace the corresponding placeholders in the message.
   * @param string $language the language code (e.g. `en-US`, `en`). If this is null, the current
   * [[\yii\base\Application::language|application language]] will be used.
   *
   * @return string the translated message.
   */
  public static function t($category, $message, $params = [], $language = null)
  {
    return Yii::t('amstr1k/' . $category, $message, $params, $language);
  }
}