<?php
declare(strict_types=1);

namespace backend\repositories;

use backend\helpers\ApiParamsHelper;

class BookFormRepository
{
    public function getFormFields($pageUid): array
    {
        return [
            'pageUid' => $pageUid ? $pageUid : ApiParamsHelper::createGuid(),
            'title'   => null,
            'review'  => null,
        ];
    }

}
