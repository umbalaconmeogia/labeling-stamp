<?php

use batsg\migrations\BaseMigrationCreateTable;

/**
 * Handles the creation of table `stamp`.
 */
class m180607_104433_create_stamp_table extends BaseMigrationCreateTable
{
    public $table = 'stamp';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTableWithExtraFields($this->table, [
            'id' => $this->primaryKey(),
            'file' => $this->text(),
            'price' => $this->integer(),
            'price_setting' => $this->smallInteger()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
