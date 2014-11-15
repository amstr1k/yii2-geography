<?php

namespace amstr1k\geography\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

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
  public function behaviors()
  {
    return [
      TimestampBehavior::className(),
    ];
  }

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
      [['title'], 'required'],
      [['geoname_id'], 'integer'],
      [['latitude', 'longitude'], 'double'],
      [['country_id'], 'exist', 'targetClass' => Country::className(), 'targetAttribute' => 'id'],
      [['title'], 'string', 'max' => 512],
      [['identifier'], 'string', 'max' => 255],
      [['is_published'], 'safe']
    ];
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels()
  {
    return [
      'id'           => Yii::t('geography', 'ID'),
      'title'        => Yii::t('geography', 'TITLE'),
      'country'      => Yii::t('geography', 'COUNTRY'),
      'country_id'   => Yii::t('geography', 'COUNTRY'),
      'latitude'     => Yii::t('geography', 'LATITUDE'),
      'longitude'    => Yii::t('geography', 'LONGITUDE'),
      'is_published' => Yii::t('geography', 'PUBLISHED'),
      'identifier'   => Yii::t('geography', 'IDENTIFIER'),
    ];
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getCountry()
  {
    return $this->hasOne(Country::className(), ['id' => 'country_id']);
  }
}
