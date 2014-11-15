<?php

use yii\db\Schema;
use yii\db\Migration;

class m141105_215555_create_geoname_country extends Migration
{
  public function safeUp()
  {
    $tableOptions = null;

    if($this->db->driverName === 'mysql')
      $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

    $this->createTable('{{%geoname_country}}', [
      'iso'                  => Schema::TYPE_STRING . '(2)',
      'iso3'                 => Schema::TYPE_STRING . '(3)',
      'iso_numeric'          => Schema::TYPE_INTEGER . '(11)',
      'fips'                 => Schema::TYPE_STRING . '(2)',
      'country'              => Schema::TYPE_STRING . '(255)',
      'capital'              => Schema::TYPE_STRING . '(255)',
      'area'                 => Schema::TYPE_STRING . '(2)',
      'population'           => Schema::TYPE_STRING . '(2)',
      'continent'            => Schema::TYPE_STRING . '(2)',
      'continent'            => Schema::TYPE_STRING . '(2)',
      'tld'                  => Schema::TYPE_STRING . '(10)',
      'currency_code'        => Schema::TYPE_STRING . '(10)',
      'currency_name'        => Schema::TYPE_STRING . '(255)',
      'phone'                => Schema::TYPE_STRING . '(255)',
      'postal_code_format'   => Schema::TYPE_STRING . '(255)',
      'postal_code_regex'    => Schema::TYPE_STRING . '(255)',
      'languages'            => Schema::TYPE_STRING . '(255)',
      'geoname_id'           => Schema::TYPE_INTEGER . '(11)',
      'neighbours'           => Schema::TYPE_STRING . '(255)',
      'equivalent_fips_code' => Schema::TYPE_STRING . '(255)',
      'PRIMARY KEY (`iso`)'
    ], $tableOptions);
  }

  public function safeDown()
  {
    $this->dropTable('{{%geoname_country}}');
  }
}
