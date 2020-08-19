<?php
/**
 * View of \frontend\widgets\RpcFormWidget
 */

/* @var string $template */
/* @var string $csrf */

?>
<form method="post">
    <?= $template ?>
  <input type="hidden" name="_csrf" value="<?= $csrf ?>">
  <input type="submit" class="btn btn-default center-block">
</form>
