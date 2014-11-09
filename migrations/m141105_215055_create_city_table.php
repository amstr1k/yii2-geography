<?php

use yii\db\Schema;
use yii\db\Migration;

class m141105_215055_create_city_table extends Migration
{
    public function safeUp()
    {
      $tableOptions = null;
      if ($this->db->driverName === 'mysql') {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
      }

      $this->createTable('{{%city}}', [
        'id' => 'pk',
        'geoname_id' => Schema::TYPE_INTEGER . '(11)',
        'title' => Schema::TYPE_STRING . '(255)',
        'region' => Schema::TYPE_STRING . '(255)',
        'identifier' => Schema::TYPE_STRING . '(255)',
        'latitude' => Schema::TYPE_DECIMAL,
        'longitude' => Schema::TYPE_DECIMAL,
        'alternate_names' => Schema::TYPE_STRING . '(5000)',
        'is_published' => 'tinyint(1) NOT NULL DEFAULT 0',
        'country_id' => Schema::TYPE_INTEGER . '(11)',
        'author_id' => Schema::TYPE_INTEGER . '(11)',
        'updater_id' => Schema::TYPE_INTEGER . '(11)',
        'created_at' => Schema::TYPE_INTEGER . '(11) NOT NULL',
        'updated_at' => Schema::TYPE_INTEGER . '(11) NOT NULL',
      ], $tableOptions);
    }

    public function safeDown()
    {
      $this->dropTable('{{%city}}');
    }
}
