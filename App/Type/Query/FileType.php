<?php

namespace App\Type\Query;

use App\Types;
use App\DB;
use GraphQL\Type\Definition\ObjectType;

/**
 * Тип File для GraphQL
 *
 */
class FileType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Файл',
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
                    'path' => [
                        'type' => Types::string(),
                        'description' => 'путь'
                    ],
                    'date_added' => [
                        'type' => Types::string(),
                        'description' => 'дата добавления'
                    ],
                    'date_updated' => [
                        'type' => Types::string(),
                        'description' => 'дата обновления'
                    ],
                    'date_deleted' => [
                        'type' => Types::string(),
                        'description' => 'дата удаления'
                    ],
                ];
            }
        ];
        parent::__construct($config);
    }
}