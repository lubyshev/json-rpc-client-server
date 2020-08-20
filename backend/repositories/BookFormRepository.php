<?php
declare(strict_types=1);

namespace backend\repositories;

use backend\models\Book;
use common\models\fields\FormTypeField;
use yii\web\NotFoundHttpException;

class BookFormRepository extends FormRepository
{
    private const ACTION_GET = 'get';
    private const ACTION_POST = 'post';

    public function getFormFields(array $params ): array
    {
        $pageUid = $params['pageUid'];
        $form = $this->getFormByUuid($pageUid);
        if (FormTypeField::TYPE_BOOK !== $form->formType->getValue()) {
            throw new NotFoundHttpException('Page not found');
        }
        $model = $this->getBookByUuid($form->uuid);
        if (!$model) {
            $model       = new Book();
            $model->uuid = $form->uuid;
        }
        if(self::ACTION_POST === $params['action']) {
            $model->setAttributes($params, false);
            $model->save();
        }

        return [
            'formType' => FormTypeField::TYPE_BOOK,
            'pageUid'  => $model->uuid,
            'title'    => $model->title,
            'review'   => $model->review,
        ];
    }

    private function getBookByUuid(string $uuid): ?Book
    {
        return $uuid
            ? (Book::findOne(['uuid' => $uuid]) ?? null)
            : null;
    }

}
