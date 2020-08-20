<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\services\RpcClientService;
use yii\web\Controller;

class PageController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionIndex(string $uuid)
    {
        $service = new RpcClientService();
        if (!empty(\Yii::$app->request->post())) {
            $data = $service->postFormByUuid($uuid);
        } else {
            $data = $service->getFormByUuid($uuid);
        }

        return $this->render('index', [
            'formData' => $data['result'],
        ]);
    }
}
