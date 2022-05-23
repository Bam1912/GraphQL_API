<?php

namespace App\Type\Mutation;

use App\Types;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Тип InputCity для GraphQL
 */
class InputCityType extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Добавление города',
            'fields' => function() {
                return [
                    'id' => [
                        'type' => Types::id(),
                        'description' => 'Идентификатор страны'
                    ],
                    'country_id' => [
                        'type' => Types::nonNull(Types::id()),
                        'description' => 'Идентификатор страны'
                    ],
                    'name' => [
                        'type' => Types::nonNull(Types::string()),
                        'description' => 'Название страны'
                    ],
                    'description' => [
                        'type' => Types::string(),
                        'description' => 'описание'
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
