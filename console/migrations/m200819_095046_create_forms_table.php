<?php
declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_forms}}`.
 */
class m200819_095046_create_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%forms}}', [
            'id'        => $this->primaryKey(),
            'uuid'      => $this->char(36)->unique(),
            'formType'  => $this->string(50)->notNull(),
            'title'     => $this->string(50)->notNull(),
            'createdAt' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
        ]);
        $this->createIndex(
            'idx-forms-form_type',
            '{{%forms}}',
            'formType'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-forms-form_type',
            '{{%forms}}'
        );
        $this->dropTable('{{%forms}}');
    }
}
