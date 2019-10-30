<?php

declare(strict_types = 1);

namespace Model\Repository;

use Model\Entity;

class Product
{
    /**
     * Поиск продуктов по массиву id
     *
     * @param int[] $ids
     * @return Entity\Product[]
     */
    public function search(array $ids = []): array
    {
        if (!count($ids)) {
            return [];
        }

        $productList = [];
        foreach ($this->getDataFromSource(['id' => $ids]) as $item) {
            $productList[] = new Entity\Product($item['id'], $item['name'], $item['price'],$item['desc']);
        }

        return $productList;
    }

    /**
     * Получаем все продукты
     *
     * @return Entity\Product[]
     */
    public function fetchAll(): array
    {
        $productList = [];
        foreach ($this->getDataFromSource() as $item) {
            $productList[] = new Entity\Product($item['id'], $item['name'], $item['price'],$item['desc']);
        }

        return $productList;
    }

    /**
     * Получаем продукты из источника данных
     *
     * @param array $search
     *
     * @return array
     */
    private function getDataFromSource(array $search = [])
    {
        $dataSource = [
            [
                'id' => 1,
                'name' => 'PHP',
                'price' => 15300,
                'desc' => 'Описание',
            ],
            [
                'id' => 2,
                'name' => 'Python',
                'price' => 20400,
                'desc' => 'Описание',
            ],
            [
                'id' => 3,
                'name' => 'C#',
                'price' => 30100,
                'desc' => 'Описание',
            ],
            [
                'id' => 4,
                'name' => 'Java',
                'price' => 30600,
                'desc' => 'Описание',
            ],
            [
                'id' => 5,
                'name' => 'Ruby',
                'price' => 18600,
                'desc' => 'Описание',
            ],
            [
                'id' => 8,
                'name' => 'Delphi',
                'price' => 8400,
                'desc' => 'Описание',
            ],
            [
                'id' => 9,
                'name' => 'C++',
                'price' => 19300,
                'desc' => 'Описание',
            ],
            [
                'id' => 10,
                'name' => 'C',
                'price' => 12800,
                'desc' => 'Описание',
            ],
            [
                'id' => 11,
                'name' => 'Lua',
                'price' => 5000,
                'desc' => 'Описание',
            ],
            [
                'id' => 12,
                'name' => 'Rust',
                'price' => 50000,
                'desc' => 'Це RUST',
            ],
        ];

        if (!count($search)) {
            return $dataSource;
        }

        $productFilter = function (array $dataSource) use ($search): bool {
            return in_array($dataSource[key($search)], current($search), true);
        };

        return array_filter($dataSource, $productFilter);
    }
}
