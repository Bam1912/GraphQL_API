<?php

namespace App\Type\Query;

use App\Types;
use App\DB;
use GraphQL\Type\Definition\ObjectType;

/**
 * Тип Form для GraphQL
 *
 */
class FormType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Данные формы',
            'fields' => function() {
                return [
                    'id' => [
                        'type' => Types::id(),
                        'description' => 'Идентификатор'
                    ],
                    'landing_id' => [
                        'type' => Types::id(),
                        'description' => 'id лэндинга'
                    ],
                    'title' => [
                        'type' => Types::string(),
                        'description' => 'заголовок'
                    ],
                    'subtitle' => [
                        'type' => Types::string(),
                        'description' => 'подзаголовок'
                    ],
                    'confirmation' => [
                        'type' => Types::string(),
                        'description' => 'ответ на submit'
                    ],
                    'popup' => [
                        'type' => Types::boolean(),
                        'description' => 'признак вcплывающей формы'
                    ],
                    'inputs' => [
                        'type' => Types::listOf(Types::FormInputs()),
                        'description' => 'список полей формы',
                        'resolve' => function ($root) {
                            return DB::select("SELECT * FROM landingfrominputs WHERE form_id = '{$root->id}' order by sort_order, id");
                        }
                   ],
                    // 'name' => [
                    //     'type' => Types::string(),
                    //     'description' => 'имя'
                    // ],                    
                    // 'placeholder' => [
                    //     'type' => Types::string(),
                    //     'description' => 'placeholder'
                    // ],                    
                    // 'required' => [
                    //     'type' => Types::boolean(),
                    //     'description' => 'обязательное'
                    // ],   
                    // 'pattern' => [
                    //     'type' => Types::string(),
                    //     'description' => 'паттерн'
                    // ],                                     
                    // 'type' => [
                    //     'type' => Types::string(),
                    //     'description' => 'тип'
                    // ],                    
                ];
            }
        ];
        parent::__construct($config);
    }
}