<?php

namespace App\Type\Query;

use App\Types;
use App\DB;
use GraphQL\Type\Definition\ObjectType;

/**
 * Тип Place для GraphQL
 *
 */
class PlaceType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Место',
            'fields' => function() {
                return [
                    'id' => [
                        'type' => Types::id(),
                        'description' => 'Идентификатор'
                    ],
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
                    'persons' => [
                         'type' => Types::listOf(Types::person()),
                         'description' => 'Персоны места',
                         'resolve' => function ($root) {
                             return DB::select("SELECT p.* FROM persons p JOIN place_to_person pts ON pts.person_id = p.id WHERE pts.place_id = {$root->id}");
                         }
                    ],
                    'storage_id' => [
                        'type' => Types::id(),
                        'description' => 'Идентификатор хранилища'
                    ],
                    'links' => [
                         'type' => Types::listOf(Types::links()),
                         'description' => 'Ссылки',
                         'resolve' => function ($root) {
                             return DB::select("SELECT psc.id id, sc.name channel, sc.is_active is_active, psc.link link FROM place_social_links psc 
                                                JOIN social_channels sc ON sc.id = psc.social_id
                                                WHERE psc.place_id = {$root->id}");
                         }
                    ],
                ];
            }
        ];
        parent::__construct($config);
    }
}