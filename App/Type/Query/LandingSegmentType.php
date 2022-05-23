<?php

namespace App\Type\Query;

use App\Types;
use GraphQL\Type\Definition\ObjectType;

/**
 * Тип LandingSegment для GraphQL
 *
 */
class LandingSegmentType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Сегментр лэндинга',
            'fields' => function() {
                return [
                    'id' => [
                        'type' => Types::id(),
                        'description' => 'Идентификатор'
                    ],
                    'landing_id' => [
                        'type' => Types::id(),
                        'description' => 'Идентификатор лэндинга'
                    ],
                    'type' => [
                        'type' => Types::int(),
                        'description' => 'тип сегмента'
                    ],
                    'name' => [
                        'type' => Types::string(),
                        'description' => 'Title'
                    ],
                    'title' => [
                        'type' => Types::string(),
                        'description' => 'Title'
                    ],
                    'titleEffect' => [
                        'type' => Types::string(),
                        'description' => 'TitleEffect'
                    ],
                    'subtitle' => [
                        'type' => Types::string(),
                        'description' => 'SubTitle'
                    ],
                    'subtitleEffect' => [
                        'type' => Types::string(),
                        'description' => 'SubTitleEffect'
                    ],                    
                    'color' => [
                        'type' => Types::string(),
                        'description' => 'Цвет фона'
                    ],
                    'content' => [
                        'type' => Types::string(),
                        'description' => 'Content'
                    ],
                    'contentEffect' => [
                        'type' => Types::string(),
                        'description' => 'ContentEffect'
                    ],
                    'sort_order' => [
                        'type' => Types::int(),
                        'description' => 'Порядок сортировки'
                    ],
                    'is_hidden' => [
                        'type' => Types::boolean(),
                        'description' => 'Скрыт'
                    ],
                ];
            }
        ];
        parent::__construct($config);
    }
}