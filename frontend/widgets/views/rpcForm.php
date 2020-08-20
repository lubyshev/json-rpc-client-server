<?php
/**
 * View of \frontend\widgets\RpcFormWidget
 */

/* @var array $formData */
/* @var string $template */
/* @var string $csrf */

?>
  <h1><?= ucfirst($formData['fields']['formType']) ?> page</h1>
  <hr/>
  <hr/><h2>Form:</h2>
  <hr/>
  <form method="post">
      <?= $template ?>
    <input type="hidden" name="_csrf" value="<?= $csrf ?>">
    <input type="submit" class="btn btn-default center-block">
  </form>
  <hr/>
  <hr/><h2>Data from Json-Rpc server:</h2>
  <hr/>
<?php
\yii\helpers\VarDumper::dump($formData, 10, true);
