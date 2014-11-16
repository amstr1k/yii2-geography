<?php

namespace amstr1k\geography\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use amstr1k\geography\Module;

class Country extends ActiveRecord
{
  const COUNTRY_UNPUBLISHED = 0;
  const COUNTRY_PUBLISHED = 1;

  /**
   * @inheritdoc
   */
  public static function tableName()
  {
    return '{{%country}}';
  }

  /**
   * @inheritdoc
   */
  public function behaviors()
  {
    return [
      TimestampBehavior::className(),
    ];
  }

  /**
   * @return CountryQuery
   */
  public static function find()
  {
    return new CountryQuery(get_called_class());
  }

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
      [['title'], 'required'],
      [['geoname_id', 'capital_id'], 'integer'],
      [['title'], 'string', 'max' => 512],
      [['worldpart'], 'string', 'max' => 255],
      [['iso', 'is_published'], 'safe']
    ];
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels()
  {
    return [
      'id'           => Module::t('geography', 'ID'),
      'title'        => Module::t('geography', 'TITLE'),
      'is_published' => Module::t('geography', 'PUBLISHED'),
    ];
  }
}
