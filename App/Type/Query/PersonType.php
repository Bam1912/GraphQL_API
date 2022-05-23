<?php

namespace App\Type\Query;

use App\Types;
use App\DB;
use GraphQL\Type\Definition\ObjectType;

/**
 * Тип Person для GraphQL
 */
class PersonType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Персона',
            'fields' => function() {
                return [
                    'id' => [
                        'type' => Types::id(),
                        'description' => 'Идентификатор персоны'
                    ],
                    'name' => [
                        'type' => Types::string(),
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
                    'company' => [
                        'type' => Types::listOf(Types::company()),
                        'description' => 'Компания',
                        'resolve' => function ($root) {
                            return DB::select("SELECT c.* from companies c JOIN persons p ON p.company_id = c.id WHERE p.id = {$root->id}");
                        }
                    ],
                    
                    // 'friends' => [
                    //     'type' => Types::listOf(Types::user()),
                    //     'description' => 'Друзья пользователя',
                    //     'resolve' => function ($root) {
                    //         return DB::select("SELECT u.* from friendships f JOIN users u ON u.id = f.friend_id WHERE f.user_id = {$root->id}");
                    //     }
                    // ],
                    // 'countFriends' => [
                    //     'type' => Types::int(),
                    //     'description' => 'Количество друзей пользователя',
                    //     'resolve' => function ($root) {
                    //         return DB::affectingStatement("SELECT u.* from friendships f JOIN users u ON u.id = f.friend_id WHERE f.user_id = {$root->id}");
                    //     }
                    // ]
                ];
            }
        ];
        parent::__construct($config);
    }
}