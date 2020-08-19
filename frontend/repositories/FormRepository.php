<?php
declare(strict_types=1);

namespace frontend\repositories;

use common\models\Form;
use yii\web\NotFoundHttpException;

class FormRepository
{
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

    /**
     * @param string $formType
     *
     * @return Form[]
     */
    public function getFormTypeByUuid(string $uuid): string
    {
        $formType = Form::find()
            ->select('formType')
            ->where(['uuid' => $uuid])
            ->scalar();
        if (!$formType) {
            throw new NotFoundHttpException('Page not found');
        }

        return $formType;
    }

}
