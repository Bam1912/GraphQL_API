<?php

namespace App\Type\Query;

use App\Types;
// use App\DB;
use GraphQL\Type\Definition\ObjectType;

/**
 * Тип Links для GraphQL
 */
class LinksType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Ссылки',
            'fields' => function() {
                return [
                    'id' => [
                        'type' => Types::id(),
                        'description' => 'Идентификатор ссылки'
                    ],
                    'link' => [
                        'type' => Types::string(),
                        'description' => 'Имя ссылки'
                    ],
                    'channel' => [
                        'type' => Types::string(),
                        'description' => 'канал'
                    ],
                    'is_active' => [
                        'type' => Types::boolean(),
                        'description' => 'канал активен'
                    ],
                ];
            }
        ];
        parent::__construct($config);
    }
}