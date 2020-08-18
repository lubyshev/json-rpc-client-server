<?php
declare(strict_types=1);

namespace backend\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\HttpException;

class RpcController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'index' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        \Yii::$app->response->headers->add('json-rpc-version', '2.0');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return parent::beforeAction($action);
    }

    /**
     * Точка входа Json-Rpc.
     *
     * @return array
     */
    public function actionIndex(): array
    {
        \Yii::$app->response->headers->add('json-rpc-id', 12);

        throw new HttpException(500, 'Parse error', -32700);
    }

}
