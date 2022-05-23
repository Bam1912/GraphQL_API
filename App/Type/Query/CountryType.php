<?php

namespace App\Type\Query;

use App\DB;
use App\Types;
use GraphQL\Type\Definition\ObjectType;

/**
 * Тип Country для GraphQL
 */
class CountryType extends ObjectType
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
                    'name' => [
                        'type' => Types::string(),
                        'description' => 'Название страны'
                    ],
                    'description' => [
                        'type' => Types::string(),
                        'description' => 'описание'
                    ],
                    'citys' => [
                        'type' => Types::listOf(Types::city()),
                        'description' => 'Список городов страны',
                        'resolve' => function ($root) {
                            return DB::select("SELECT citys.* from citys JOIN countries ON citys.country_id = countries.id WHERE citys.country_id = {$root->id}");
                        }
                    ],
                    'citysCount' => [
                        'type' => Types::int(),
                        'description' => 'Количество городов страны',
                        'resolve' => function ($root) {
                            return DB::affectingStatement("SELECT citys.* from citys JOIN countries ON citys.country_id = countries.id WHERE citys.country_id = {$root->id}");
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