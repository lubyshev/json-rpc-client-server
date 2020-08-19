<?php
declare(strict_types=1);

namespace backend\repositories;

use backend\helpers\ApiParamsHelper;
use backend\models\Form;

class FormRepository
{
    public function getForm(string $formType, ?string $pageUid = null): Form
    {
        $form = $this->getFormByUuid($pageUid);
        if (!$form) {
            $form = new Form();
            do {
                $form->uuid = ApiParamsHelper::createGuid();
            } while (
                $this->getFormByUuid($form->uuid)
            );
            $form->formType->setValue($formType);
        }

        return $form;
    }

    private function getFormByUuid(?string $uuid): ?Form
    {
        return $uuid
            ? (Form::findOne(['uuid' => $uuid]) ?? null)
            : null;
    }

}
