<?php

namespace amstr1k\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Inflector;

class Country extends \yii\db\ActiveRecord
{
  /**
   * @inheritdoc
   */
  public static function tableName ()
  {
    return '{{%country}}';
  }

  /**
   * @return CountryQuery
   */
  public static function find ()
  {
    return new CountryQuery(get_called_class());
  }

  /**
   * @inheritdoc
   */
  public function rules ()
  {
    return [
      [['title'], 'required'],
      [['title'], 'string', 'max' => 512]
    ];
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels ()
  {
    return [
      'id'    => Yii::t('common', 'ID'),
      'title' => Yii::t('common', 'Title'),
    ];
  }
}
