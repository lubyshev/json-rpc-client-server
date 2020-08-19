<?php
declare(strict_types=1);

namespace frontend\widgets;

use yii\base\Widget;
use frontend\services\RpcTemplateService;

class RpcFormWidget extends Widget
{
    public array $fields;

    public string $template;

    public function run()
    {
        return $this->render('rpcForm', [
            'template' => (new RpcTemplateService())->prepareTemplate($this->fields, $this->template),
            'csrf'     => \Yii::$app->request->csrfToken,
        ]);
    }

}
