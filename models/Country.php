<?php

namespace amstr1k\geography\models;

use Yii;
use yii\db\ActiveRecord;

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
      [['title'], 'string', 'max' => 512]
    ];
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels()
  {
    return [
      'id'    => Yii::t('geography', 'ID'),
      'title' => Yii::t('geography', 'TITLE'),
    ];
  }
}
