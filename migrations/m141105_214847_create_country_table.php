<?php

use yii\db\Schema;
use yii\db\Migration;

class m141105_214847_create_country_table extends Migration
{
  public function safeUp()
  {
    $tableOptions = null;

    if($this->db->driverName === 'mysql')
      $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

    $this->createTable('{{%country}}', [
      'id'           => 'pk',
      'title'        => Schema::TYPE_STRING . '(255)',
      'geoname_id'   => Schema::TYPE_INTEGER . '(11)',
      'capital_id'   => Schema::TYPE_INTEGER . '(11)',
      'worldpart'    => Schema::TYPE_STRING . '(255)',
      'iso'          => Schema::TYPE_STRING . '(2)',
      'is_published' => 'tinyint(1) NOT NULL DEFAULT 0',
      'created_at'   => Schema::TYPE_INTEGER . '(11) NOT NULL',
      'updated_at'   => Schema::TYPE_INTEGER . '(11) NOT NULL',
    ], $tableOptions);
  }

  public function safeDown()
  {
    $this->dropTable('{{%country}}');
  }
}
