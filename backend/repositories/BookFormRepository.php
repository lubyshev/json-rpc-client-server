<?php
declare(strict_types=1);

namespace backend\repositories;

use backend\models\Book;
use common\models\fields\FormTypeField;
use yii\web\NotFoundHttpException;

class BookFormRepository extends FormRepository
{
    public function getFormFields(string $pageUid): array
    {
        $form = $this->getFormByUuid($pageUid);
        if(FormTypeField::TYPE_BOOK !== $form->formType->getValue()) {
            throw new NotFoundHttpException('Page not found');
        }
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
