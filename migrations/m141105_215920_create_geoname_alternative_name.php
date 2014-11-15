<?php

use yii\db\Schema;
use yii\db\Migration;

class m141105_215920_create_geoname_alternative_name extends Migration
{
  public function safeUp()
  {
    $tableOptions = null;

    if($this->db->driverName === 'mysql')
      $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

    $this->createTable('{{%geoname_alternative_name}}', [
      'alternate_name_id' => 'pk',
      'geoname_id'        => Schema::TYPE_INTEGER,
      'iso_language'      => Schema::TYPE_STRING . '(7)',
      'alternate_name'    => Schema::TYPE_STRING . '(200)',
      'is_preferred_name' => Schema::TYPE_INTEGER . '(1)',
      'is_short_name'     => Schema::TYPE_INTEGER . '(1)',
      'is_colloquial'     => Schema::TYPE_INTEGER . '(1)',
      'is_historic'       => Schema::TYPE_INTEGER . '(1)',
    ], $tableOptions);
  }

  public function safeDown()
  {
    $this->dropTable('{{%geoname_alternative_name}}');
  }
}
