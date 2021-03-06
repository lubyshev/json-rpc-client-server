<?php
declare(strict_types=1);

namespace backend\repositories;

use common\models\Form;
use yii\web\NotFoundHttpException;

class FormRepository
{
    public function findFormByUuid(string $uuid): ?Form
    {
        return Form::findOne(['uuid' => $uuid]);
    }

    public function getFormByUuid(string $uuid): Form
    {
        $form = $this->findFormByUuid($uuid);
        if (!$form) {
            throw new NotFoundHttpException('Page not found');
        }

        return $form;
    }

    /**
     * @param string $formType
     *
     * @return Form[]
     */
    public function getAllFormsByType(string $formType): array
    {
        return Form::find()
            ->where(['formType' => $formType])
            ->orderBy(['id' => SORT_ASC])
            ->all();
    }

}
