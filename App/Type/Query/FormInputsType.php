<?php

namespace App\Type\Query;

use App\Types;
use App\DB;
use GraphQL\Type\Definition\ObjectType;

/**
 * Тип FormInputs для GraphQL
 *
 */
class FormInputsType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Данные полей формы',
            'fields' => function() {
                return [
                    'id' => [
                        'type' => Types::id(),
                        'description' => 'Идентификатор'
                    ],
                    'name' => [
                        'type' => Types::string(),
                        'description' => 'имя'
                    ],                    
                    'placeholder' => [
                        'type' => Types::string(),
                        'description' => 'placeholder'
                    ],                    
                    'required' => [
                        'type' => Types::boolean(),
                        'description' => 'обязательное'
                    ],   
                    'pattern' => [
                        'type' => Types::string(),
                        'description' => 'паттерн'
                    ],                                     
                    'type' => [
                        'type' => Types::string(),
                        'description' => 'тип'
                    ],                    
                ];
            }
        ];
        parent::__construct($config);
    }
}