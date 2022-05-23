<?php

namespace App\Type\Mutation;

use App\Types;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Тип InputCountry для GraphQL
 */
class InputCountryType extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Добавление страны',
            'fields' => function() {
                return [
                    'id' => [
                        'type' => Types::id(),
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
