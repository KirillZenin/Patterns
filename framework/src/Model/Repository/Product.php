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
        $product = new Entity\Product(0, '', 0, '');
        foreach ($this->getDataFromSource(['id' => $ids]) as $item) {
            $product->setId($item['id']);
            $product->setPrice($item['price']);
            $product->setName($item['name']);
            $product->setDescription($item['description']);
            $productList[] = clone $product;
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
        $product = new Entity\Product(0, '', 0, '');
        foreach ($this->getDataFromSource() as $item) {
            $product->setId($item['id']);
            $product->setPrice($item['price']);
            $product->setName($item['name']);
            $product->setDescription($item['description']);
            $productList[] = clone $product;
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
                'description' => 'Cкриптовый язык общего назначения, интенсивно применяемый для разработки веб-приложений',
            ],
            [
                'id' => 2,
                'name' => 'Python',
                'price' => 20400,
                'description' => 'Высокоуровневый язык программирования общего назначения, ориентированный на улучшение  производительности разработчика и читаемости кода'
            ],
            [
                'id' => 3,
                'name' => 'C#',
                'price' => 30100,
                'description' => 'Результат объединения С++, Java и Delphi c элементами функционального программирования.'
            ],
            [
                'id' => 4,
                'name' => 'Java',
                'price' => 30600,
                'description' => 'JAVA'
            ],
            [
                'id' => 5,
                'name' => 'Ruby',
                'price' => 18600,
                'description' => 'Python с некоторыми обвесами'
            ],
            [
                'id' => 8,
                'name' => 'Delphi',
                'price' => 8400,
                'description' => "Суть - Pascal с классами, ыл очень популярен из-за возможности создания оконных десктоп-приложений "
            ],
            [
                'id' => 9,
                'name' => 'C++',
                'price' => 19300,
                'description' => "Один из самых известных языков, много IDE, много где используется "
            ],
            [
                'id' => 10,
                'name' => 'C',
                'price' => 12800,
                'description' => "язык программирования, разработанный придуманный по приколу в пиндосской компании Bell Labs в начале 1970-х годов Деннисом Ритчи. "
            ],
            [
                'id' => 11,
                'name' => 'Lua',
                'price' => 5000,
                'description' => " скриптовый язык, напоминающий C. Используется в некоторых играх (wow, например) и эмуляторах для реализации ИИ и пр. хрени. Грядет на замену убогим шаблонам MediaWiki, в Википедиях уже доступен."
            ],
            [
                'id' => 12,
                'name' => 'Rust',
                'price' => 12000,
                'description' => "всё, хватит. Кто в 16 лет не мечтал запилить свой язык программирования, который наконец-то позволит писать всё и сразу, у того нет сердца."
            ]
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
