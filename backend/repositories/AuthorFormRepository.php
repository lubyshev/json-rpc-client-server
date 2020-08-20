<?php
declare(strict_types=1);

namespace backend\repositories;

use backend\models\Author;
use common\models\fields\FormTypeField;
use yii\web\NotFoundHttpException;

class AuthorFormRepository extends FormRepository
{
    private const ACTION_GET = 'get';
    private const ACTION_POST = 'post';

    public function getFormFields(array $params): array
    {
        $pageUid = $params['pageUid'];
        $form = $this->getFormByUuid($pageUid);
        if (FormTypeField::TYPE_AUTHOR !== $form->formType->getValue()) {
            throw new NotFoundHttpException('Page not found');
        }
        $model = $this->getAuthorByUuid($form->uuid);
        if (!$model) {
            $model       = new Author();
            $model->uuid = $form->uuid;
        }
        if(self::ACTION_POST === $params['action']) {
            $model->setAttributes($params, false);
            $model->save();
        }

        return [
            'formType'   => FormTypeField::TYPE_AUTHOR,
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
