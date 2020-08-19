<?php
declare(strict_types=1);

namespace backend\repositories;

use backend\models\Author;
use backend\models\fields\FormTypeField;

class AuthorFormRepository extends FormRepository
{
    public function getFormFields(?string $pageUid): array
    {
        $form = $this->getForm(FormTypeField::TYPE_AUTHOR, $pageUid);
        $form->save();
        $model = $this->getAuthorByUuid($form->uuid);
        if (!$model) {
            $model       = new Author();
            $model->uuid = $form->uuid;
        }

        return [
            'pageUid'    => $model->uuid,
            'name'       => $model->name,
            'lastName'   => $model->lastName,
            'middleName' => $model->middleName,
            'biography'  => $model->biography,
        ];
    }

    private function getAuthorByUuid(string $uuid): ?Author
    {
        return $uuid
            ? (Author::findOne(['uuid' => $uuid]) ?? null)
            : null;
    }

}
