<?php

use yii\db\Schema;
use yii\db\Migration;

class m141105_214847_create_country_table extends Migration
{
    public function safeUp()
    {
      $this->createTable('{{%country}}', [
        'id' => 'pk',
        'geoname_id' => Schema::TYPE_INTEGER . '(11)',
        'capital_id' => Schema::TYPE_INTEGER . '(11)',
        'title' => Schema::TYPE_STRING . '(255)',
        'text' => Schema::TYPE_TEXT,
        'author_id' => Schema::TYPE_INTEGER . '(11)',
        'updater_id' => Schema::TYPE_INTEGER . '(11)',
        'worldpart' => Schema::TYPE_STRING . '(255)',
        'iso' => Schema::TYPE_STRING . '(2)',
        'is_published' => 'tinyint(1) NOT NULL DEFAULT 0',
        'created_at' => Schema::TYPE_INTEGER . '(11) NOT NULL',
        'updated_at' => Schema::TYPE_INTEGER . '(11) NOT NULL',
      ]);
    }

    public function safeDown()
    {
        echo "m141105_214847_create_country_table cannot be reverted.\n";

        return false;
    }
}
