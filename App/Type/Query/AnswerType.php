<?php

namespace App\Type\Query;

use App\Types;
use GraphQL\Type\Definition\ObjectType;

/**
 * Тип Answer для GraphQL
 */
class AnswerType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Ответ',
            'fields' => function() {
                return [
                    'success' => [
                        'type' => Types::boolean(),
                        'description' => 'признак успешного завершения чего либо'
                    ],
                    'message' => [
                        'type' => Types::string(),
                        'description' => 'Сообщение'
                    ],
                ];
            }
        ];
        parent::__construct($config);
    }
}