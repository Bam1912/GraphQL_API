<?php

namespace App\Type\Mutation;

use App\Types;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Тип InputFormData для GraphQL
 */
class InputFormDataType extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'мутация данных форм',
            'fields' => function() {
                return [
                    'landing_id' => [
                        'type' => Types::id(),
                        'description' => 'id лэндинга'
                    ],
                    'form_id' => [
                        'type' => Types::nonNull(Types::id()),
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
