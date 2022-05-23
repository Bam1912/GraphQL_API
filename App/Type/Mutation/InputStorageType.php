<?php

namespace App\Type\Mutation;

use App\Types;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Тип InputStorage для GraphQL
 */
class InputStorageType extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'мутация хранилища]',
            'fields' => function() {
                return [
                    'file_id' => [
                        'type' => Types::id(),
                        'description' => 'Тип'
                    ],

                ];
            }
        ];
        parent::__construct($config);
    }
}
