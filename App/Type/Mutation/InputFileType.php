<?php

namespace App\Type\Mutation;

use App\Types;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Тип InputFile для GraphQL
 */
class InputFileType extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'мутация файла',
            'fields' => function() {
                return [
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
