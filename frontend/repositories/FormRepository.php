<?php
declare(strict_types=1);

namespace frontend\repositories;

use frontend\traits\RpcClientTrait;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class FormRepository
{
    use RpcClientTrait;

    private const RPC_METHOD_ALL_FORMS = 'getAllForms';
    private const FORMS_KEY            = 'rpc:forms';
    private const FORMS_KEY_TTL        = 300;

    private ?array $forms;

    public function __construct()
    {
        $forms = \Yii::$app->cache->get(self::FORMS_KEY);
        if (!$forms) {
            $response = $this->sendRequest(
                self::RPC_METHOD_ALL_FORMS,
                []
            );
            $forms    = json_decode((string)$response->getBody(), true);
            if (!$forms) {
                throw new InternalErrorException('Internal server error');
            }
            $this->checkRequestResult($response, $forms);
            $forms = $forms['result'];
            \Yii::$app->cache->set(
                self::FORMS_KEY,
                $forms,
                self::FORMS_KEY_TTL
            );
        }
        $this->forms = $forms;
    }

    /**
     * @param string $formType
     *
     * @return ?[]
     */
    public function getAllFormsByType(string $formType): ?array
    {
        return $this->forms[$formType];
    }

    /**
     * @param string $uuid
     *
     * @return string
     */
    public function getFormTypeByUuid(string $uuid): string
    {
        $result = null;
        foreach ($this->forms as $type => $items) {
            foreach ($items as $item) {
                if ($item['uuid'] === $uuid) {
                    $result = $type;
                    break;
                }
            }
            if ($result) {
                break;
            }
        }
        if (!$result) {
            throw new InternalErrorException('Internal server error');
        }

        return $result;
    }

}
