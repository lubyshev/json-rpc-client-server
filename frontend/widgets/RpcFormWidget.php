<?php
declare(strict_types=1);

namespace frontend\widgets;

use frontend\services\RpcClientService;
use yii\base\Widget;
use frontend\services\RpcTemplateService;

class RpcFormWidget extends Widget
{
    public string $pageUid;

    public function run()
    {
        $service = new RpcClientService();
        if (!empty(\Yii::$app->request->post())) {
            $response = $service->postFormByUuid($this->pageUid);
        } else {
            $response = $service->getFormByUuid($this->pageUid);
        }
        $data = $response['result'];

        return $this->render('rpcForm', [
            'formData' => $data,
            'template' => (new RpcTemplateService())->prepareTemplate($data['fields'], $data['template']),
            'csrf'     => \Yii::$app->request->csrfToken,
        ]);
    }

}
