<?php
declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m200819_095028_create_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books}}', [
            'id'     => $this->primaryKey(),
            'uuid'   => $this->char(36)->unique(),
            'title'  => $this->string(150)->notNull(),
            'review' => $this->text()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%books}}');
    }

}
