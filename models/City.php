<?php

namespace amstr1k\geography\models;

use Yii;
use yii\db\ActiveRecord;

class City extends ActiveRecord
{
  /**
   * @inheritdoc
   */
  public static function tableName()
  {
    return '{{%city}}';
  }

  /**
   * @return CityQuery
   */
  public static function find()
  {
    return new CityQuery(get_called_class());
  }

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
      [['title'], 'required'],
      [['country_id'], 'exist', 'targetClass' => Country::className(), 'targetAttribute' => 'id'],
      [['title'], 'string', 'max' => 512]
    ];
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels()
  {
    return [
      'id'      => Yii::t('geography', 'ID'),
      'title'   => Yii::t('geography', 'TITLE'),
      'country' => Yii::t('geography', 'COUNTRY'),
      'country_id' => Yii::t('geography', 'COUNTRY'),
    ];
  }

  public function getCountry()
  {
    return $this->hasOne(Country::className(), ['id' => 'country_id']);
  }
}
