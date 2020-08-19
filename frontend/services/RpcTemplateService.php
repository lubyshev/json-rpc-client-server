<?php
declare(strict_types=1);

namespace frontend\services;

class RpcTemplateService
{
    public function prepareTemplate(array $fields, string $template): string
    {
        unset($fields['formType']);
        unset($fields['pageUid']);
        foreach ($fields as $field => $value) {
            $template = preg_replace(
                '~{{ '.$field.' }}~us',
                $value ? $value : '',
                $template
            );
        }

        return $template;
    }

}
