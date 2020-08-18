<?php
define('ROOT_DIR', realpath(__DIR__.'/../..'));

(Dotenv\Dotenv::createUnsafeImmutable(ROOT_DIR))->load();

return [
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => ROOT_DIR.'/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
