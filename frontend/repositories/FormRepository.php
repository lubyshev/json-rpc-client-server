<?php
declare(strict_types=1);

namespace frontend\repositories;

use common\models\Form;

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

}
