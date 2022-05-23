<?php

namespace App\Type\Query;

use App\DB;
use App\Types;
use GraphQL\Type\Definition\ObjectType;

/**
 * Тип City для GraphQL
 *
 */
class CityType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Страна',
            'fields' => function() {
                return [
                    'id' => [
                        'type' => Types::id(),
                        'description' => 'Идентификатор страны'
                    ],
                    'country_id' => [
                        'type' => Types::id(),
                        'description' => 'Идентификатор страны'
                    ],
                    'name' => [
                        'type' => Types::string(),
                        'description' => 'Название страны'
                    ],
                    'description' => [
                        'type' => Types::string(),
                        'description' => 'описание'
                    ],
                    // 'sights' => [
                    //     'type' => Types::listOf(Types::sight()),
                    //     'description' => 'Список достопримечательностей страны',
                    //     'resolve' => function ($root) {
                    //         return DB::select("SELECT sights.* from sights JOIN citys ON sights.city_id = citys.id WHERE sights.city_id = {$root->id}");
                    //     }
                    // ],
                    // 'sightsCount' => [
                    //     'type' => Types::int(),
                    //     'description' => 'Количество городов страны',
                    //     'resolve' => function ($root) {
                    //         return DB::affectingStatement("SELECT sights.* from sights JOIN citys ON sights.city_id = citys.id WHERE sights.city_id = {$root->id}");
                    //     }
                    // ],
                    'places' => [
                        'type' => Types::listOf(Types::place()),
                        'description' => 'Список мест города',
                        'resolve' => function ($root) {
                            return DB::select("SELECT places.* from places JOIN citys ON places.city_id = citys.id WHERE places.city_id = {$root->id}");
                        }
                    ],
                    'placesCount' => [
                        'type' => Types::int(),
                        'description' => 'Количество мест города',
                        'resolve' => function ($root) {
                            return DB::affectingStatement("SELECT places.* from places JOIN citys ON places.city_id = citys.id WHERE places.city_id = {$root->id}");
                        }
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