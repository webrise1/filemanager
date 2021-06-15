<?php

use yii\db\Migration;

/**
 * Class m210609_155151_filemanager_create_table_file
 */
class m210609_155151_filemanager_create_table_file extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%filemanager_file}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'path' => $this->string(255)->notNull(),
            'folderNS' => $this->string(255)->notNull(),
            'hashcode' => $this->string(255)->notNull(),
            'created_at' => 'datetime DEFAULT NOW()'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%filemanager_file}}');
    }


}
