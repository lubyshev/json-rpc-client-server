<?php
declare(strict_types=1);

namespace backend\repositories;

use backend\helpers\ApiParamsHelper;

class AuthorFormRepository
{
    public function getFormFields($pageUid): array
    {
        return [
            'pageUid'    => $pageUid ? $pageUid : ApiParamsHelper::createGuid(),
            'name'       => null,
            'lastName'   => null,
            'middleName' => null,
            'biography'  => null,
        ];
    }

}
