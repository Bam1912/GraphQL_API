<?php

namespace App\Type\Query;

use App\Types;
use App\DB;
use GraphQL\Type\Definition\ObjectType;

/**
 * Тип Channels для GraphQL
 */
class ChannelsType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Социальные каналы',
            'fields' => function() {
                return [
                    'id' => [
                        'type' => Types::id(),
                        'description' => 'Идентификатор канала'
                    ],
                    'name' => [
                        'type' => Types::string(),
                        'description' => 'Название накала'
                    ],
                    'is_active' => [
                        'type' => Types::boolean(),
                        'description' => 'канал активен'
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }
}