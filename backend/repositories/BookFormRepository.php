<?php
declare(strict_types=1);

namespace backend\repositories;

use backend\models\Book;
use backend\models\fields\FormTypeField;

class BookFormRepository extends FormRepository
{
    public function getFormFields(?string $pageUid): array
    {
        $form = $this->getForm(FormTypeField::TYPE_BOOK, $pageUid);
        $form->save();
        $model = $this->getBookByUuid($form->uuid);
        if (!$model) {
            $model       = new Book();
            $model->uuid = $form->uuid;
        }

        return [
            'pageUid' => $model->uuid,
            'title'   => $model->title,
            'review'  => $model->review,
        ];
    }

    private function getBookByUuid(string $uuid): ?Book
    {
        return $uuid
            ? (Book::findOne(['uuid' => $uuid]) ?? null)
            : null;
    }

}
