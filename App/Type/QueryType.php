<?php

namespace App\Type;

use App\DB;
use App\Types;
use GraphQL\Type\Definition\ObjectType;

class QueryType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => function() {
                return [
                    'getForm' => [
                        'type' => Types::form(),
                        'description' => 'формa',
                        'args' => [
                            'form_id' => Types::ID(),
                        ],
                        'resolve' => function ($root, $args) {
                            return DB::selectOne("SELECT * FROM landingforms WHERE id = '{$args['form_id']}'");
                        }
                    ],
                    
                    'getForms' => [
                        'type' => Types::listOf(Types::form()),
                        'description' => 'список форм',
                        'args' => [
                            'landing_id' => Types::ID(),
                        ],
                        'resolve' => function ($root, $args) {
                            return DB::select("SELECT * FROM landingforms WHERE landing_id = '{$args['landing_id']}'");
                        }
                    ],

                    // 'getFormInputs' => [
                    //     'type' => Types::listOf(Types::form()),
                    //     'description' => 'данные полей формы',
                    //     'args' => [
                    //         'landing_id' => Types::ID(),
                    //     ],
                    //     'resolve' => function ($root, $args) {
                    //         return DB::select("SELECT lfi.* FROM landingfrominputs lfi JOIN landingforms l USING(form_id) WHERE landing_id = '{$args['landing_id']}'");
                    //     }
                    // ],

                    'FormData' => [
                        'type' => Types::listOf(Types::formData()),
                        'description' => 'сохраненные данные формы',
                        'args' => [
                            'landing_id' => Types::ID(),
                            'form_id' => Types::ID()
                        ],
                        'resolve' => function ($root, $args) {
                            return DB::select("SELECT * from landingformdata WHERE landing_id = '{$args['landing_id']}' and form_id = '{$args['form_id']}'");
                        }
                    ],

                    'Storage' => [
                        'type' => Types::storage(),
                        'description' => 'хранилище',
                        'args' => [
                            'storage_id' => Types::ID()
                        ],
                        'resolve' => function ($root, $args) {
                            return DB::selectOne("SELECT * from storages WHERE id = {$args['storage_id']}");
                        }
                    ],

                    'Persons' => [
                        'type' => Types::listOf(Types::person()),
                        'description' => 'список персон',
                        'resolve' => function () {
                            return DB::select('SELECT * from persons');
                        }
                    ],

                    'Person' => [
                        'type' => Types::person(),
                        'description' => 'персона',
                        'args' => [
                            'person_id' => Types::ID()
                        ],
                        'resolve' => function ($root, $args) {
                            return DB::selectOne("SELECT * from persons WHERE id = {$args['person_id']}");
                        }
                    ],

                    'Companies' => [
                        'type' => Types::listOf(Types::company()),
                        'description' => 'список компаний',
                        'resolve' => function () {
                            return DB::select('SELECT * from companies');
                        }
                    ],

                    'Company' => [
                        'type' => Types::company(),
                        'description' => 'компания',
                        'args' => [
                            'company_id' => Types::ID()
                        ],
                        'resolve' => function ($root, $args) {
                            return DB::selectOne("SELECT * from companies WHERE id = {$args['company_id']}");
                        }
                    ],

                    'Channels' => [
                        'type' => Types::listOf(Types::channels()),
                        'description' => 'список социальных каналов',
                        'resolve' => function () {
                            return DB::select('SELECT * from social_channels');
                        }
                    ],

                    'Places' => [
                        'type' => Types::listOf(Types::place()),
                        'description' => 'список мест',
                        'resolve' => function () {
                            return DB::select('SELECT * from places');
                        }
                    ],

                    'Places_links' => [
                        'type' => Types::listOf(Types::place()),
                        'description' => 'места с лендингами',
                        'resolve' => function () {
                            return DB::select('SELECT p.* FROM places p
                                                LEFT JOIN place_social_links psc ON p.id = psc.place_id
                                                WHERE psc.link IS NOT NULL');
                        }
                    ],

                    'Place' => [
                        'type' => Types::place(),
                        'description' => 'место',
                        'args' => [
                            'place_id' => Types::ID()
                        ],
                        'resolve' => function ($root, $args) {
                            return DB::selectOne("SELECT * from places WHERE id = {$args['place_id']}");
                        }
                    ],

                    'User' => [
                        'type' => Types::user(),
                        'description' => 'возвращает пользователя по id',
                        'args' => [
                            'id' => Types::int()
                        ],
                        'resolve' => function ($root, $args) {
                            return DB::selectOne("SELECT * from users WHERE id = {$args['id']}");
                        }
                    ],

                    'Users' => [
                        'type' => Types::listOf(Types::user()),
                        'description' => 'список пользователей',
                        'resolve' => function () {
                            return DB::select('SELECT * from users');
                        }
                    ],

                    'Countries' => [
                        'type' => Types::listOf(Types::country()),
                        'description' => 'список стран',
                        'resolve' => function () {
                            return DB::select('SELECT * from countries');
                        }
                    ],

                    'Country' => [
                        'type' => Types::listOf(Types::country()),
                        'description' => 'информация по стране со списком городов страны',
                        'args' => [
                            'country_id' => Types::ID()
                        ],
                        'resolve' => function ($root, $args) {
                            return DB::select("SELECT * from countries WHERE id = {$args['country_id']}");
                        }
                    ],

                    'Citys' => [
                        'type' => Types::listOf(Types::city()),
                        'description' => 'список городов',
                        'resolve' => function () {
                            return DB::select('SELECT * from citys');
                        }
                    ],

                    'City' => [
                        'type' => Types::city(),//listOf(Types::city()),
                        'description' => 'информация по городу со списком достопримечательностей',
                        'args' => [
                            'city_id' => Types::ID()
                        ],
                        'resolve' => function ($root, $args) {
                            return DB::selectOne("SELECT * from citys WHERE id = {$args['city_id']}"); //select(...
                        }
                    ],

                    'Landings' => [
                        'type' => Types::listOf(Types::landing()),
                        'description' => 'список лэндингов',
                        'resolve' => function () {
                            return DB::select('SELECT * from landings');
                        }
                    ],

                    'Landing' => [
                        'type' => Types::landing(),
                        'description' => 'информация лэндингу',
                        'args' => [
                            'landing_id' => Types::ID()
                        ],
                        'resolve' => function ($root, $args) {
                            return DB::selectOne("SELECT * from landings WHERE id = {$args['landing_id']}");
                        }
                    ],
                ];
            }
        ];
        parent::__construct($config);
    }
}