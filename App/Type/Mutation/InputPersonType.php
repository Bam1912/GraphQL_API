<?php

namespace App\Type\Mutation;

use App\Types;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Тип InputPerson для GraphQL
 */
class InputPersonType extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Добавление персоны',
            'fields' => function() {
                return [
                    // 'id' => [
                    //     'type' => Types::id(),
                    //     'description' => 'Идентификатор персоны'
                    // ],
                    'name' => [
                        'type' => Types::nonNull(Types::string()),
                        'description' => 'Имя'
                    ],
                    'second_name' => [
                        'type' => Types::string(),
                        'description' => 'Фамилия'
                    ],
                    'email' => [
                        'type' => Types::string(),
                        'description' => 'Email'
                    ],
                    'phone' => [
                        'type' => Types::string(),
                        'description' => 'телефон'
                    ],
                    'comments' => [
                        'type' => Types::string(),
                        'description' => 'Примечания'
                    ],
                    'date_added' => [
                        'type' => Types::datetime(),
                        'description' => 'Имя'
                    ],
                    'company_id' => [
                        'type' => Types::id(),
                        'description' => 'id Компании'
                    ],
                ];
            }
        ];
        parent::__construct($config);
    }
}
