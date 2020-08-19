<?php
declare(strict_types=1);

use common\helpers\ApiParamsHelper;
use common\models\fields\FormTypeField;
use common\models\Form;
use yii\db\Migration;

/**
 * Class m200819_204037_populate_forms_table
 */
class m200819_204037_populate_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $forms = [
            'Book #1'   => FormTypeField::TYPE_BOOK,
            'Book #2'   => FormTypeField::TYPE_BOOK,
            'Author #1' => FormTypeField::TYPE_AUTHOR,
            'Author #2' => FormTypeField::TYPE_AUTHOR,
        ];

        foreach ($forms as $title => $formType) {
            $form        = $this->createForm($formType);
            $form->title = $title;
            $form->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200819_204037_populate_forms_table cannot be reverted.\n";

        return false;
    }

    private function createForm(string $formType): Form
    {
        $form = new Form();
        do {
            $form->uuid = ApiParamsHelper::createGuid();
        } while (
            Form::findOne(['uuid' => $form->uuid])
        );
        $form->formType->setValue($formType);

        return $form;
    }


}
