<?php
declare(strict_types=1);

/** @var array $formData */

use frontend\widgets\RpcFormWidget;

?>
  <h1><?= ucfirst($formData['fields']['formType']) ?> page</h1>
  <hr/><hr/><h2>Form:</h2>
  <hr/>
<?=
RpcFormWidget::widget([
    'fields'   => $formData['fields'],
    'template' => $formData['template'],
])
?>
  <hr/><hr/><h2>Data from Json-Rpc server:</h2>
  <hr/>
<?php \yii\helpers\VarDumper::dump($formData, 10, true); ?>

<?php
