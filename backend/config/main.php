<?php

use Fig\Http\Message\StatusCodeInterface as StatusCodes;
use yii\web\Response;

$params = array_merge(
    require __DIR__.'/../../common/config/params.php',
    require __DIR__.'/../../common/config/params-local.php',
    require __DIR__.'/params.php',
    require __DIR__.'/params-local.php'
);

return [
    'id'                  => 'app-backend',
    'basePath'            => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap'           => ['log'],
    'modules'             => [],
    'components'          => [
        'request'      => [
            'csrfParam' => '_csrf-backend',
            'parsers'   => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response'     => [
            'on beforeSend' => function ($event) {
                /** @var Response $response */
                $response = $event->sender;
                if ($response->format === Response::FORMAT_JSON && $response->data !== null) {
                    if ($response->statusCode !== StatusCodes::STATUS_OK) {
                        $code           = (int)$response->data['code'];
                        $message        = $response->data['message'];
                        $headers        = $response->getHeaders();
                        $response->data = [
                            'jsonrpc' => $headers['json-rpc-version'],
                            'id'      =>
                                isset($headers['json-rpc-id'])
                                    ? (int)$headers['json-rpc-id']
                                    : null,
                            'error'   => [
                                "code"    => $code,
                                "message" => $message,
                            ],
                        ];
                    }
                }
            },
        ],
        'user'         => [
            'identityClass'   => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie'  => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session'      => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                'rpc' => 'rpc/index',
            ],
        ],
    ],
    'params'              => $params,
];
