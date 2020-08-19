<?php
declare(strict_types=1);

namespace frontend\controllers;

use frontend\services\RpcClientService;
use yii\web\Controller;

class PageController extends Controller
{
    public function actionIndex(string $uuid)
    {
        return $this->render('index', [
            'formData' => ((new RpcClientService())->getFormByUuid($uuid))['result'],
        ]);
    }
}
