<?php

namespace App\Type\Query;

use App\Types;
use App\DB;
use GraphQL\Type\Definition\ObjectType;

/**
 * Тип Landing для GraphQL
 *
 */
class LandingType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Лэндинг',
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
                    'phone' => [
                        'type' => Types::string(),
                        'description' => 'телефон'
                    ],
                    'email' => [
                        'type' => Types::string(),
                        'description' => 'email'
                    ],
                    'social' => [
                        'type' => Types::string(),
                        'description' => 'ссылки на социальные сети'
                    ],
                    'organization' => [
                        'type' => Types::string(),
                        'description' => 'реквизиты организации'
                    ],
                    'link' => [
                        'type' => Types::string(),
                        'description' => 'ссылка'
                    ],
                    'date_added' => [
                        'type' => Types::string(),
                        'description' => 'Дата создания'
                    ],
                    'date_deleted' => [
                        'type' => Types::string(),
                        'description' => 'Дата удаление'
                    ],
                    'is_active' => [
                        'type' => Types::boolean(),
                        'description' => 'Активно'
                    ],
                    'segments' => [
                         'type' => Types::listOf(Types::landingSegment()),
                         'description' => 'список сегментов лендинга',
                         'resolve' => function ($root) {
                             return DB::select("SELECT ls.* FROM landingsegments ls JOIN landings l  ON l.id = ls.landing_id WHERE ls.landing_id = {$root->id} and is_hidden='0' ORDER BY ls.sort_order, ls.id");
                         }
                    ],
                ];
            }
        ];
        parent::__construct($config);
    }
}