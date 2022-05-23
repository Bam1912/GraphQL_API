<?php

namespace App\Type\Mutation;

use App\Types;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Тип InputUser для GraphQL
 */
class InputUserType extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Добавление пользователя',
            'fields' => function() {
                return [
                    'name' => [
                        'type' => Types::nonNull(Types::string()),
                        'description' => 'Имя пользователя'
                    ],
                    'username' => [
                        'type' => Types::nonNull(Types::string()),
                        'description' => 'ник'
                    ],
                    'password' => [
                        'type' => Types::nonNull(Types::string()),
                        'description' => 'пароль'
                    ],
                ];
            }
        ];
        parent::__construct($config);
    }
}
