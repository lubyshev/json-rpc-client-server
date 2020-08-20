<?php
declare(strict_types=1);

/** @var string $pageUid */

use frontend\widgets\RpcFormWidget;

echo RpcFormWidget::widget([
    'pageUid' => $pageUid,
]);
