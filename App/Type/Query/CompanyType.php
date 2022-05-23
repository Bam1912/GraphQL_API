<?php

namespace App\Type\Query;

use App\Types;
use App\DB;
use GraphQL\Type\Definition\ObjectType;

/**
 * Тип Company для GraphQL
 */
class CompanyType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Компания',
            'fields' => function() {
                return [
                    'id' => [
                        'type' => Types::id(),
                        'description' => 'Идентификатор компании'
                    ],
                    'name' => [
                        'type' => Types::string(),
                        'description' => 'Имя'
                    ],
                    'address' => [
                        'type' => Types::string(),
                        'description' => 'Адрес'
                    ],
                    'email' => [
                        'type' => Types::string(),
                        'description' => 'Email'
                    ],
                    'phone' => [
                        'type' => Types::string(),
                        'description' => 'Телефон'
                    ],
                    'description' => [
                        'type' => Types::string(),
                        'description' => 'Описание'
                    ],
                    'date_added' => [
                        'type' => Types::datetime(),
                        'description' => 'Имя'
                    ],
                    'persons' => [
                        'type' => Types::listOf(Types::person()),
                        'description' => 'Персоны компании',
                        'resolve' => function ($root) {
                            return DB::select("SELECT p.* from persons p JOIN companies c ON p.company_id = c.id WHERE c.id = {$root->id}");
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