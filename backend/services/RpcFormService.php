<?php
declare(strict_types=1);

namespace backend\services;

use backend\repositories\AuthorFormRepository;
use backend\repositories\BookFormRepository;
use backend\repositories\FormRepository;
use common\models\fields\FormTypeField;
use Fig\Http\Message\StatusCodeInterface as StatusCodes;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class RpcFormService
{
    private const RPC_METHOD_ALL_FORMS   = 'getAllForms';
    private const RPC_METHOD_AUTHOR_FORM = 'getAuthorForm';
    private const RPC_METHOD_BOOK_FORM   = 'getBookForm';

    private const RPC_METHODS = [
        self::RPC_METHOD_ALL_FORMS,
        self::RPC_METHOD_AUTHOR_FORM,
        self::RPC_METHOD_BOOK_FORM,
    ];

    private array $params;

    public function getForm(): array
    {
        $this->params = $this->getParams();
        $result       = null;
        switch ($this->params['method']) {
            case self::RPC_METHOD_ALL_FORMS:
                $result = $this->getAllForms();
                break;
            case self::RPC_METHOD_AUTHOR_FORM:
                $result = $this->getAuthorForm();
                break;
            case self::RPC_METHOD_BOOK_FORM:
                $result = $this->getBookForm();
                break;
        }

        return [
            'jsonrpc' => $this->params['jsonrpc'],
            'id'      => $this->params['id'],
            'result'  => $result,
        ];
    }

    private function getParams(): array
    {
        $params = \Yii::$app->getRequest()->getBodyParams();
        $this->checkRpcParams($params);
        if (isset($params['id']) && !empty($params['id'])) {
            \Yii::$app->response->headers->add('json-rpc-id', $params['id']);
        } else {
            $params['id'] = null;
        }
        if (
            self::RPC_METHOD_ALL_FORMS !== $params['method']
            && !$params['params']['pageUid']
        ) {
            throw new NotFoundHttpException('Page not found');
        }

        return $params;
    }

    private function getAuthorForm(): array
    {
        $fields = (new AuthorFormRepository())->getFormFields($this->params['params']);

        return [
            'fields'   => $fields,
            'template' => \Yii::$app->view->render('/rpc/authorForm', ['fields' => $fields]),
        ];
    }

    private function getBookForm(): array
    {
        $fields = (new BookFormRepository())->getFormFields($this->params['params']);

        return [
            'fields'   => $fields,
            'template' => \Yii::$app->view->render('/rpc/bookForm', ['fields' => $fields]),
        ];
    }

    private function getAllForms()
    {
        $repo = new FormRepository();

        return [
            FormTypeField::TYPE_AUTHOR => $repo->getAllFormsByType(FormTypeField::TYPE_AUTHOR),
            FormTypeField::TYPE_BOOK   => $repo->getAllFormsByType(FormTypeField::TYPE_BOOK),
        ];
    }

    private function checkRpcParams(array $params): void
    {
        if (!isset($params['jsonrpc'], $params['method'], $params['params'])) {
            throw new HttpException(
                StatusCodes::STATUS_BAD_REQUEST,
                'Invalid Request', -32600
            );
        }

        if (
            '2.0' !== $params['jsonrpc']
            || !is_array($params['params'])
        ) {
            throw new HttpException(
                StatusCodes::STATUS_INTERNAL_SERVER_ERROR,
                'Invalid params', -32602);
        }

        if (!in_array($params['method'], self::RPC_METHODS)) {
            throw new HttpException(
                StatusCodes::STATUS_NOT_FOUND,
                'Method not found', -32601);
        }

        if (
            self::RPC_METHOD_ALL_FORMS !== $params['method']
            && !array_key_exists('pageUid', $params['params'])
        ) {
            throw new HttpException(
                StatusCodes::STATUS_INTERNAL_SERVER_ERROR,
                'Invalid params', -32602);
        }
    }

}
