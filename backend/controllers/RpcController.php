<?php
declare(strict_types=1);

namespace backend\controllers;

use backend\services\RpcFormService;
use yii\filters\VerbFilter;
use yii\web\Controller;

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
        $this->enableCsrfValidation
                = false;
        $result = parent::beforeAction($action);
        \Yii::$app->response->headers->add('json-rpc-version', '2.0');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $result;
    }

    /**
     * Точка входа Json-Rpc.
     *
     * @return array
     */
    public function actionIndex(): array
    {
        return (new RpcFormService())->getForm();
    }

}
