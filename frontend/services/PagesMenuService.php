<?php
declare(strict_types=1);

namespace frontend\services;

use frontend\repositories\FormRepository;

class PagesMenuService
{
    private FormRepository $repo;

    public function __construct()
    {
        $this->repo = new FormRepository();
    }

    public function getPagesMenuItems(): array
    {
        return [
            'authors' => $this->getAuthorsMenuItem(),
            'books'   => $this->getBooksMenuItem(),
        ];
    }

    private function getAuthorsMenuItem(): array
    {
        $result = [
            'label'    => 'Authors',
            'options'  => ['class' => 'dropdown'],
            'template' => '<a href="{url}" class="url-class">{label}</a>',
            'items'    => [],
        ];

        $items = $this->repo->getAllFormsByType(
            \common\models\fields\FormTypeField::TYPE_AUTHOR
        );
        foreach ($items as $item) {
            $result['items'][] = [
                'label' => $item['title'],
                'url'   => ['page/'.$item['uuid']],
            ];
        }

        return $result;
    }

    private function getBooksMenuItem(): array
    {
        $result = [
            'label'    => 'Books',
            'options'  => ['class' => 'dropdown'],
            'template' => '<a href="{url}" class="url-class">{label}</a>',
            'items'    => [],
        ];
        $items  = $this->repo->getAllFormsByType(
            \common\models\fields\FormTypeField::TYPE_BOOK
        );
        foreach ($items as $item) {
            $result['items'][] = [
                'label' => $item['title'],
                'url'   => ['page/'.$item['uuid']],
            ];
        }

        return $result;
    }

}
