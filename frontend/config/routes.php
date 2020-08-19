<?php
declare(strict_types=1);

$uuidPattern = '([0-9a-zA-Z]){8}\-([0-9a-zA-Z]){4}\-([0-9a-zA-Z]){4}\-([0-9a-zA-Z]){4}\-([0-9a-zA-Z]){12}';

return [
    'page/<uuid:'.$uuidPattern.'>' => 'page/index',
];