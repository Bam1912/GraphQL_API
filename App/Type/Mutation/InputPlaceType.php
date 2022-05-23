<?php

namespace App\Type\Mutation;

use App\Types;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Тип InputPlace для GraphQL
 */
class InputPlaceType extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'мутация места',
            'fields' => function() {
                return [
                    'name' => [
                        'type' => Types::string(),
                        'description' => 'Название'
                    ],
                    'original_name' => [
                        'type' => Types::string(),
                        'description' => 'Оригинальное название'
                    ],
                    'address' => [
                        'type' => Types::string(),
                        'description' => 'Адрес'
                    ],
                    'type_id' => [
                        'type' => Types::id(),
                        'description' => 'Тип'
                    ],
                    'city_id' => [
                        'type' => Types::id(),
                        'description' => 'Идентификатор города'
                    ],
                    'price_category_id' => [
                        'type' => Types::id(),
                        'description' => 'Категоря цены'
                    ],
                    'coordinates' => [
                        'type' => Types::string(),
                        'description' => 'координаты'
                    ],
                    'tags' => [
                        'type' => Types::string(),
                        'description' => 'теги'
                    ],
                    'teaser' => [
                        'type' => Types::string(),
                        'description' => 'тизер'
                    ],
                    'description' => [
                        'type' => Types::string(),
                        'description' => 'описание'
                    ],
                    'internal_rating' => [
                        'type' => Types::int(),
                        'description' => 'внутренний рейтинг'
                    ],
                    'external_rating' => [
                        'type' => Types::int(),
                        'description' => 'внешний рейтинг'
                    ],
                    'activity' => [
                        'type' => Types::int(),
                        'description' => 'уровень активности'
                    ],
                    'comments' => [
                        'type' => Types::string(),
                        'description' => 'примечание'
                    ],
                    'prepayment' => [
                        'type' => Types::int(),
                        'description' => '% предоплаты'
                    ],
                    'person_id' => [
                        'type' => Types::int(),
                        'description' => '% предоплаты'
                    ],
                    'storage_id' => [
                        'type' => Types::id(),
                        'description' => 'Идентификатор хранилища'
                    ],
                ];
            }
        ];
        parent::__construct($config);
    }
}
