<?php
declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%authors}}`.
 */
class m200819_095018_create_authors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%authors}}', [
            'id'         => $this->primaryKey(),
            'uuid'       => $this->char(36)->unique(),
            'name'       => $this->string(50)->notNull(),
            'lastName'   => $this->string(50)->notNull(),
            'middleName' => $this->string(50),
            'biography'  => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%authors}}');
    }
}
