<?php

use yii\db\Schema;
use yii\db\Migration;

class m141105_215720_create_geoname_city extends Migration
{
  public function safeUp()
  {
    $tableOptions = null;

    if($this->db->driverName === 'mysql')
      $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

    $this->createTable('{{%geoname_city}}', [
      'geoname_id'        => 'pk',
      'name'              => Schema::TYPE_STRING . '(255)',
      'ascii_name'        => Schema::TYPE_INTEGER . '(255)',
      'alternate_names'   => Schema::TYPE_STRING . '(5000)',
      'latitude'          => Schema::TYPE_DECIMAL . '(10,8)',
      'longitude'         => Schema::TYPE_DECIMAL . '(11,8)',
      'feature_class'     => Schema::TYPE_STRING . '(1)',
      'feature_code'      => Schema::TYPE_STRING . '(10)',
      'country_code'      => Schema::TYPE_STRING . '(2)',
      'cc2'               => Schema::TYPE_STRING . '(2)',
      'admin1_code'       => Schema::TYPE_STRING . '(20)',
      'admin2_code'       => Schema::TYPE_STRING . '(80)',
      'admin3_code'       => Schema::TYPE_STRING . '(20)',
      'admin4_code'       => Schema::TYPE_STRING . '(20)',
      'geoname_id'        => Schema::TYPE_BIGINT . '(8)',
      'elevation'         => Schema::TYPE_INTEGER . '(11)',
      'dem'               => Schema::TYPE_INTEGER . '(11)',
      'timezone'          => Schema::TYPE_STRING . '(40)',
      'modification_date' => Schema::TYPE_DATE,
    ], $tableOptions);
  }

  public function safeDown()
  {
    $this->dropTable('{{%geoname_city}}');
  }
}
