<?php
declare(strict_types=1);

namespace frontend\traits;

use Fig\Http\Message\StatusCodeInterface as StatusCodes;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use yii\web\HttpException;

trait RpcClientTrait
{
    private function sendRequest(string $methodName, array $params): ResponseInterface
    {
        return (new Client([
            'base_uri'    => getenv('JSON_RPC_SERVER_HOST'),
            'timeout'     => 2.0,
            'http_errors' => false,
        ]))->post('', [
            'json' => [
                'jsonrpc' => '2.0',
                'id'      => 1,
                'method'  => $methodName,
                'params'  => $params,
            ]
            ,
        ]);
    }

    /**
     * Проверка результатов запроса.
     *
     * @param ResponseInterface $response Ответ на запрос.
     * @param array             $data     Данные ответа на запрос.
     *
     * @throws \yii\web\HttpException
     */
    private function checkRequestResult(ResponseInterface $response, array $data): void
    {
        if (StatusCodes::STATUS_OK !== $response->getStatusCode()) {
            throw new HttpException(
                $response->getStatusCode(),
                $data['error']['message'],
                $data['error']['code']
            );
        }
    }

}