<?php
declare(strict_types=1);

namespace frontend\controllers;

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
        return $this->render('index', [
            'pageUid' => $uuid,
        ]);
    }
}
