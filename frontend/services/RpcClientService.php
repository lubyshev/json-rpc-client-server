<?php
declare(strict_types=1);

namespace frontend\services;

use common\models\fields\FormTypeField;
use Fig\Http\Message\StatusCodeInterface as StatusCodes;
use frontend\repositories\FormRepository;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;

class RpcClientService
{
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

    /**
     * Проверка результатов запроса.
     *
     * @param ResponseInterface $response Ответ на запрос.
     * @param array             $data     Данные ответа на запрос.
     *
     * @throws \yii\web\HttpException
     */
    private function checkRequestResult(ResponseInterface $response, array $data): void
    {
        if (StatusCodes::STATUS_OK !== $response->getStatusCode()) {
            throw new HttpException(
                $response->getStatusCode(),
                $data['error']['message'],
                $data['error']['code']
            );
        }
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
        $post['action'] = 'post';

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

    private function sendRequest(string $methodName, array $params): ResponseInterface
    {
        return (new Client([
            'base_uri'    => getenv('JSON_RPC_SERVER_HOST'),
            'timeout'     => 2.0,
            'http_errors' => false,
        ]))->post('', [
            'json' => [
                'jsonrpc' => '2.0',
                'id'      => 1,
                'method'  => $methodName,
                'params'  => $params,
            ]
            ,
        ]);
    }

}
