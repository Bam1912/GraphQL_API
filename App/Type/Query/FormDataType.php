<?php

namespace App\Type\Query;

use App\Types;
use App\DB;
use GraphQL\Type\Definition\ObjectType;

/**
 * Тип FormData для GraphQL
 *
 */
class FormDataType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Данные формы',
            'fields' => function() {
                return [
                    'id' => [
                        'type' => Types::id(),
                        'description' => 'Идентификатор'
                    ],
                    'landing_id' => [
                        'type' => Types::string(),
                        'description' => 'id лэндинга'
                    ],
                    'form_id' => [
                        'type' => Types::id(),
                        'description' => 'id формы'
                    ],
                    'data' => [
                        'type' => Types::string(),
                        'description' => 'данные'
                    ],
                    'date_added' => [
                        'type' => Types::string(),
                        'description' => 'дата добавления данных'
                    ],
                ];
            }
        ];
        parent::__construct($config);
    }
}