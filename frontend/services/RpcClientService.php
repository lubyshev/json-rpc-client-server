<?php
declare(strict_types=1);

namespace frontend\services;

use common\models\fields\FormTypeField;
use frontend\repositories\FormRepository;
use frontend\traits\RpcClientTrait;
use yii\web\BadRequestHttpException;

class RpcClientService
{
    use RpcClientTrait;

    private const AUTHOR_FORM_METHOD = 'getAuthorForm';
    private const BOOK_FORM_METHOD   = 'getBookForm';

    private FormRepository $repo;

    public function __construct()
    {
        $this->repo = new FormRepository();
    }

    public function getFormByUuid(string $uuid): array
    {
        return $this->getFormParams(
            $uuid,
            $this->repo->getFormTypeByUuid($uuid)
        );
    }

    public function postFormByUuid(string $uuid)
    {
        return $this->postFormParams(
            $uuid,
            $this->repo->getFormTypeByUuid($uuid)
        );
    }

    private function getFormParams(string $uuid, string $formType): array
    {
        $response = $this->sendRequest(
            $this->getRpcMethodName($formType),
            [
                'pageUid' => $uuid,
                'action'  => 'get',
            ]
        );
        $result   = json_decode((string)$response->getBody(), true);
        $this->checkRequestResult($response, $result);

        return $result;
    }

    private function postFormParams(string $uuid, string $formType): array
    {
        $post = \Yii::$app->request->post();
        if (!\Yii::$app->request->validateCsrfToken($post['_csrf'])) {
            throw new BadRequestHttpException('Bad Request');
        }
        unset($post['_csrf']);
        $post['pageUid'] = $uuid;
        $post['action']  = 'post';

        $response = $this->sendRequest(
            $this->getRpcMethodName($formType),
            $post
        );

        $result = json_decode((string)$response->getBody(), true);
        $this->checkRequestResult($response, $result);

        return $result;
    }

    private function getRpcMethodName(string $formType): string
    {
        $method = null;
        switch ($formType) {
            case FormTypeField::TYPE_AUTHOR:
                $method = self::AUTHOR_FORM_METHOD;
                break;
            case FormTypeField::TYPE_BOOK:
                $method = self::BOOK_FORM_METHOD;
                break;
        }
        if (!$method) {
            throw new \HttpRequestMethodException("Invalid form type: `{$formType}`");
        }

        return $method;
    }

}
