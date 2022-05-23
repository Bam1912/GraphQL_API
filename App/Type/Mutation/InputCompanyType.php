<?php

namespace App\Type\Mutation;

use App\Types;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Тип InputCompany для GraphQL
 */
class InputCompanyType extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Добавление компании',
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
                    'address' => [
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
                    'description' => [
                        'type' => Types::string(),
                        'description' => 'Примечания'
                    ],
                    'date_added' => [
                        'type' => Types::datetime(),
                        'description' => 'Имя'
                    ]                    
                ];
            }
        ];
        parent::__construct($config);
    }
}
