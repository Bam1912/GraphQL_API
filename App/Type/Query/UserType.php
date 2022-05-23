<?php

namespace App\Type\Query;

use App\Types;
use GraphQL\Type\Definition\ObjectType;

/**
  * Тип User для GraphQL
  */
class UserType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Пользователь',
            'fields' => function() {
                return [
                    'id' => [
                        'type' => Types::string(),
                        'description' => 'Идентификатор пользователя'
                    ],
                    'name' => [
                        'type' => Types::string(),
                        'description' => 'Имя пользователя'
                    ],
                    'username' => [
                        'type' => Types::string(),
                        'description' => 'ник'
                    ],
                    'password' => [
                        'type' => Types::string(),
                        'description' => 'пароль'
                    ],
                    // ,
                    // 'email' => [
                    //     'type' => Types::string(),
                    //     'description' => 'E-mail пользователя'
                    // ],
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