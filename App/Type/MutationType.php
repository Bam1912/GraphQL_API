<?php

namespace App\Type;

use App\DB;
use App\Types;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class MutationType
 *
 * Корневой тип Mutation для GraphQL
 * @package App\Type
 */
class MutationType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => function() {
                return [
                    'saveFormData' => [
                        'type' => Types::formData(),
                        'description' => 'Сохранение данных форму',
                        'args' => [
                            'landing_id' => Types::string(),
                            'form_id' => Types::ID(),
                            'data' => Types::string()
                        ],
                        'resolve' => function ($root, $args) {
                            $Id = DB::insert("INSERT INTO landingformdata (`landing_id`, `form_id`, `data`, `date_added`) 
                                                    VALUES ('".addslashes($args['landing_id'])."','{$args['form_id']}','".addslashes($args['data'])."','".date("Y-m-d H:i:s")."')");
                            $info = DB::selectOne("SELECT * from landingforms WHERE id = {$args['form_id']} and landing_id= '".addslashes($args['landing_id'])."'");
                            $data = DB::selectOne("SELECT * from landingformdata WHERE id = $Id");
                            
                            /** Отправка email уведомлений
                            */
                            if(!empty($info->notification_email)) {
                                $email_admin = $info->notification_email;
                                $headers = "From: LevelFive.ru <info@levelfive.ru>\r\nTo: =?utf-8?B?".base64_encode("$email_admin")."?= <$email_admin>\r\nContent-Type: text/html;charset=\"UTF-8\"\r\nContent-Transfer-Encoding: 8bit";
                                $subject_admin = "Поступила новая заявка";
                                $message_user = $subject_user = $info->confirmation;
                                $message_admin = "Поступила новая заявка<hr>";
                                $message_user .= "<br><br>Вы указали в отправке следующие данные:";
                                
                                if(!empty($data->data))
                                    foreach(json_decode($data->data) as $key=>$val){
                                        $message_admin .=  "<br>".$key.' => '.$val;
                                        if($key!='landing_id' && $key != 'form_id') $message_user .=  "<br>".$val;
                                        if($key == 'email') {
                                            $email_user = $val;
                                            $headers_user = "From: LevelFive.ru <info@levelfive.ru>\r\nTo: =?utf-8?B?".base64_encode("$email_user")."?= <$email_user>\r\nContent-Type: text/html;charset=\"UTF-8\"\r\nContent-Transfer-Encoding: 8bit";
                                        }
                                    }
                                mail($email_admin, $subject_admin, $message_admin,$headers);    //письмо менеджеру

                                if(!empty($email_user)){
                                    mail($email_user, $subject_user, $message_user,$headers_user);    //письмо пользователю
                                }
                            }
                            
                            return $data;
                        }
                    ],

                    'addStorage' => [
                        'type' => Types::storage(),
                        'description' => 'Добавление хранилища',
                        'resolve' => function ($root, $args) {
                            $Id = DB::insert("INSERT INTO storages (`date_added`) 
                                                    VALUES ('".date("Y-m-d H:i:s")."')");
                            return DB::selectOne("SELECT * from storages WHERE id = $Id");
                        }
                    ],

                    'deleteFromStorage' => [
                        'type' => Types::answer(),
                        'description' => 'Удаление файла из хранилища',
                        'args' => [
                            'storage_id' => Types::ID(),
                            'file_id' => Types::ID()
                        ],
                        'resolve' => function ($root, $args) {
                            $affected_rows = DB::update("DELETE f, stf FROM files f INNER JOIN storage_to_file stf ON stf.file_id = f.id WHERE stf.storage_id={$args['storage_id']} AND f.id={$args['file_id']}");
                                if($affected_rows) return (object) ["success"=>true, "message"=>"файл удалена"];
                                    else return (object) ["success"=>false, "message"=>"файл с ID={$args['file_id']} не найдена"];
                        }
                    ],

                    'addToStorage' => [
                        'type' => Types::answer(),
                        'description' => 'Добавление в хранилище',
                        'args' => [
                            'storage_id' => Types::ID(),
                            'file' => Types::inputFile()
                        ],
                        'resolve' => function ($root, $args) {
                            $cnt =  DB::affectingStatement("SELECT f.* FROM files f JOIN storage_to_file s ON s.file_id = f.id WHERE s.storage_id = {$args['storage_id']} and f.name= '".addslashes($args['file']['name'])."'");
                            if($cnt == 0){
                                $fId = DB::insert("INSERT INTO files (`name`, `path`, `date_added`) 
                                                    VALUES ('".addslashes($args['file']['name'])."', '".addslashes($args['file']['path'])."', NOW() )");
                                if(!empty($fId)){
                                    $sId = DB::insert("INSERT INTO storage_to_file (`storage_id`, `file_id`) VALUES ({$args['storage_id']}, {$fId})");
                                    
                                    if(!empty($sId)) return (object) ["success"=>true, "message"=>"файл добавлен"];
                                        else return (object) ["success"=>false, "message"=>"файл сохранен но не добавлен в хранилище {$sId}"];
                                }
                                    else return (object) ["success"=>false, "message"=>"файл не сохранен"];
                            }
                            elseif($cnt == 1){
                                $affected_rows = DB::update("UPDATE files f JOIN storage_to_file s ON f.id = s.file_id
                                                            SET f.path='".addslashes($args['file']['path'])."', f.date_updated=NOW() WHERE s.storage_id = {$args['storage_id']} and f.name= '".addslashes($args['file']['name'])."'");
                                if($affected_rows) return (object) ["success"=>true, "message"=>"файл обновлен"];
                                    else return (object) ["success"=>false, "message"=>"ошибка обновления файла"];
                            }
                                else return (object) ["success"=>false, "message"=>"уникальность хранилища нарушена"];
                        }
                    ],

                    'addCompany' => [
                        'type' => Types::company(),
                        'description' => 'Добавление компании',
                        'args' => [
                            'company' => Types::inputCompany()
                        ],
                        'resolve' => function ($root, $args) {
                            $Id = DB::insert("INSERT INTO companies (`name`, `address`, `email`, `phone`, `description`, `date_added`) 
                                                    VALUES ('".addslashes($args['company']['name'])."', '".addslashes($args['company']['address'])."', '{$args['company']['email']}', '".addslashes($args['company']['phone'])."', '".addslashes($args['company']['description'])."', '".date("Y-m-d H:i:s")."')");
                            return DB::selectOne("SELECT * from companies WHERE id = $Id");
                        }
                    ],

                    'deleteCompany' => [
                        'type' => Types::answer(),
                        'description' => 'Удаление компании',
                        'args' => [
                            'id' => Types::ID()
                        ],
                        'resolve' => function ($root, $args) {
                            $cnt =  DB::affectingStatement("SELECT persons.* from persons p WHERE p.company_id = {$args['id']}");                            
                            if($cnt == 0){
                                $affected_rows = DB::update("DELETE FROM companies WHERE id = '{$args['id']}'");
                                if($affected_rows) return (object) ["success"=>true, "message"=>"компания удалена"];
                                    else return (object) ["success"=>false, "message"=>"компания с ID={$args['id']} не найдена"];
                            }
                            else{
                                return (object) ["success"=>true, "message"=>"компания не может быть удалена так как содержит {$cnt} персон"];
                            }
                        }
                    ],

                    'addPerson' => [
                        'type' => Types::person(),
                        'description' => 'Добавление персоны',
                        'args' => [
                            'person' => Types::inputPerson()
                        ],
                        'resolve' => function ($root, $args) {
                            $Id = DB::insert("INSERT INTO persons (`name`, `second_name`, `email`, `phone`, `comments`, `date_added`) 
                                                    VALUES ('".addslashes($args['person']['name'])."', '".addslashes($args['person']['second_name'])."', '{$args['person']['email']}', '".addslashes($args['person']['phone'])."', '".addslashes($args['person']['comments'])."', '".date("Y-m-d H:i:s")."')");
                            return DB::selectOne("SELECT * from persons WHERE id = $Id");
                        }
                    ],

                    'deletePerson' => [
                        'type' => Types::answer(),
                        'description' => 'Удаление персоны',
                        'args' => [
                            'id' => Types::ID()
                        ],
                        'resolve' => function ($root, $args) {
                            $affected_rows = DB::delete("DELETE FROM persons WHERE id = '{$args['id']}'");
                                if($affected_rows) return (object) ["success"=>true, "message"=>"персона удалена"];
                                    else return (object) ["success"=>false, "message"=>"персона с ID={$args['id']} не найдена"];
                        }
                    ],

                    // 'addSight' => [
                    //     'type' => Types::sight(),
                    //     'description' => 'Добавление достопримечательности',
                    //     'args' => [
                    //         'sight' => Types::inputSight()
                    //     ],
                    //     'resolve' => function ($root, $args) {
                    //         $Id = DB::insert("INSERT INTO sights (`name`, `city_id`, `description`) VALUES ('".addslashes($args['sight']['name'])."', '{$args['sight']['city_id']}', '".addslashes($args['sight']['description'])."')");
                    //         return DB::selectOne("SELECT * from sights WHERE id = $Id");
                    //     }
                    // ],
                    // 'updateSight' => [
                    //     'type' => Types::answer(),
                    //     'description' => 'Обновление достопримечательности',
                    //     'args' => [
                    //         'id' => Types::nonNull(Types::ID()),
                    //         'sight' => Types::inputSight()
                    //     ],
                    //     'resolve' => function ($root, $args) {
                    //         $fields=[];
                    //         if(isset( $args['sight']['name'] )) { array_push($fields,"name = '".addslashes($args['sight']['name'])."'"); };
                    //         if(isset( $args['sight']['original_name'] )) { array_push($fields,"original_name = '".addslashes($args['sight']['original_name'])."'"); };
                    //         if(isset( $args['sight']['address'] )) { array_push($fields,"address = '".addslashes($args['sight']['address'])."'"); };
                    //         if(isset( $args['sight']['tags'] )) { array_push($fields,"tags = '".addslashes($args['sight']['tags'])."'"); };
                    //         if(isset( $args['sight']['teaser'] )) { array_push($fields,"teaser = '".addslashes($args['sight']['teaser'])."'"); };
                    //         if(isset( $args['sight']['description'] )) { array_push($fields,"description = '".addslashes($args['sight']['description'])."'"); };
                    //         if(isset( $args['sight']['comments'] )) { array_push($fields,"comments = '".addslashes($args['sight']['comments'])."'"); };
                    //         if(isset( $args['sight']['prepayment'] )) { array_push($fields,"prepayment = '".addslashes($args['sight']['prepayment'])."'"); };
                    //         if(isset( $args['sight']['coordinates'] )) { array_push($fields,"coordinates = '".addslashes($args['sight']['coordinates'])."'"); };

                    //         $query = "UPDATE sights SET ".implode(',',$fields)." WHERE id = {$args['id']}";
                    //         $affected_rows = DB::update($query);
                    //             if($affected_rows) return (object) ["success"=>true, "message"=>"достопримечательность обновлена"];
                    //                 else return (object) ["success"=>false, "message"=>"ошибка обновление достопримечательности с ID={$args['id']}, ".$query];
                    //     }
                    // ],
                    // 'deleteSight' => [
                    //     'type' => Types::answer(),
                    //     'description' => 'Удаление достопримечательности',
                    //     'args' => [
                    //         'id' => Types::ID()
                    //     ],
                    //     'resolve' => function ($root, $args) {
                    //         $affected_rows = DB::delete("DELETE FROM sights WHERE id = '{$args['id']}'");
                    //             if($affected_rows) return (object) ["success"=>true, "message"=>"достопримечательность удалена"];
                    //                 else return (object) ["success"=>false, "message"=>"достопримечательность с ID={$args['id']} не найдена"];
                    //     }
                    // ],

                    'addPlace' => [
                        'type' => Types::place(),
                        'description' => 'Добавление места',
                        'args' => [
                            'place' => Types::inputPlace()
                        ],
                        'resolve' => function ($root, $args) {
                            $Id = DB::insert("INSERT INTO places (`name`, `city_id`, `description`) VALUES ('".addslashes($args['place']['name'])."', '{$args['place']['city_id']}', '".addslashes($args['place']['description'])."')");
                            return DB::selectOne("SELECT * from places WHERE id = $Id");
                        }
                    ],

                    'updatePlace' => [
                        'type' => Types::answer(),
                        'description' => 'Обновление места',
                        'args' => [
                            'id' => Types::nonNull(Types::ID()),
                            'place' => Types::inputPlace()
                        ],
                        'resolve' => function ($root, $args) {
                            $fields=[];
                            if(isset( $args['place']['name'] )) { array_push($fields,"name = '".addslashes($args['place']['name'])."'"); };
                            if(isset( $args['place']['original_name'] )) { array_push($fields,"original_name = '".addslashes($args['place']['original_name'])."'"); };
                            if(isset( $args['place']['address'] )) { array_push($fields,"address = '".addslashes($args['place']['address'])."'"); };
                            if(isset( $args['place']['tags'] )) { array_push($fields,"tags = '".addslashes($args['place']['tags'])."'"); };
                            if(isset( $args['place']['teaser'] )) { array_push($fields,"teaser = '".addslashes($args['place']['teaser'])."'"); };
                            if(isset( $args['place']['description'] )) { array_push($fields,"description = '".addslashes($args['place']['description'])."'"); };
                            if(isset( $args['place']['internal_rating'] )) { array_push($fields,"internal_rating = '".addslashes($args['place']['internal_rating'])."'"); };
                            if(isset( $args['place']['activity'] )) { array_push($fields,"activity = '".addslashes($args['place']['activity'])."'"); };
                            if(isset( $args['place']['comments'] )) { array_push($fields,"comments = '".addslashes($args['place']['comments'])."'"); };
                            if(isset( $args['place']['prepayment'] )) { array_push($fields,"prepayment = '".addslashes($args['place']['prepayment'])."'"); };
                            if(isset( $args['place']['coordinates'] )) { array_push($fields,"coordinates = '".addslashes($args['place']['coordinates'])."'"); };
                            if(isset( $args['place']['storage_id'] )) { array_push($fields,"storage_id = {$args['place']['storage_id']}"); };

                            $query = "UPDATE places SET ".implode(',',$fields)." WHERE id = {$args['id']}";
                            $affected_rows = DB::update($query);
                                if($affected_rows) return (object) ["success"=>true, "message"=>"место обновлено"];
                                    else return (object) ["success"=>false, "message"=>"ошибка обновления места с ID={$args['id']}, ".$query];
                        }
                    ],

                    'deletePlace' => [
                        'type' => Types::answer(),
                        'description' => 'Удаление места',
                        'args' => [
                            'id' => Types::ID()
                        ],
                        'resolve' => function ($root, $args) {
                            $affected_rows = DB::delete("DELETE FROM places WHERE id = '{$args['id']}'");
                                if($affected_rows) return (object) ["success"=>true, "message"=>"место удалено"];
                                    else return (object) ["success"=>false, "message"=>"место с ID={$args['id']} не найдено"];
                        }
                    ],

                    'addUser' => [
                        'type' => Types::user(),
                        'description' => 'Добавление пользователя',
                        'args' => [
                            'user' => Types::inputUser()
                        ],
                        'resolve' => function ($root, $args) {
                            $Id = DB::insert("INSERT INTO users (`name`, `username`, `password`) VALUES ('{$args['user']['name']}', '{$args['user']['username']}', '{$args['user']['password']}')");
                            return DB::selectOne("SELECT * from users WHERE id = $Id");
                        }
                    ],

                    'addCountry' => [
                        'type' => Types::country(),
                        'description' => 'Добавление страны',
                        'args' => [
                            'country' => Types::inputCountry()
                        ],
                        'resolve' => function ($root, $args) {
                            $Id = DB::insert("INSERT INTO countries (`name`, `description`) VALUES ('".addslashes($args['country']['name'])."', '".addslashes($args['country']['description'])."')");
                            return DB::selectOne("SELECT * from countries WHERE id = $Id");
                        }
                    ],

                    'deleteCountry' => [
                        'type' => Types::answer(),
                        'description' => 'Удаление страны',
                        'args' => [
                            'id' => Types::ID()
                        ],
                        'resolve' => function ($root, $args) {
                            $cnt =  DB::affectingStatement("SELECT citys.* from citys WHERE citys.country_id = {$args['id']}");                            
                            if($cnt == 0){
                                $affected_rows = DB::update("DELETE FROM countries WHERE id = '{$args['id']}'");
                                if($affected_rows) return (object) ["success"=>true, "message"=>"страна удалена"];
                                    else return (object) ["success"=>false, "message"=>"страна с ID={$args['id']} не найдена"];
                            }
                            else{
                                return (object) ["success"=>true, "message"=>"страна не может быть удалена так как содержит {$cnt} стран"];
                            }
                        }
                    ],

                    'addCity' => [
                        'type' => Types::city(),
                        'description' => 'Добавление города',
                        'args' => [
                            'city' => Types::inputCity()
                        ],
                        'resolve' => function ($root, $args) {
                            $Id = DB::insert("INSERT INTO citys (`name`, `country_id`, `description`) VALUES ('".addslashes($args['city']['name'])."', '{$args['city']['country_id']}', '".addslashes($args['city']['description'])."')");
                            return DB::selectOne("SELECT * from citys WHERE id = $Id");
                        }
                    ],
                    
                    'deleteCity' => [
                        'type' => Types::Answer(),
                        'description' => 'Удаление города',
                        'args' => [
                            'id' => Types::ID()
                        ],
                        'resolve' => function ($root, $args) {
                            $cnt =  DB::affectingStatement("SELECT places.* from places WHERE places.city_id = {$args['id']}");                            
                            if($cnt == 0){
                                $affected_rows = DB::update("DELETE FROM citys WHERE id = '{$args['id']}'");
                                if($affected_rows) return (object) ["success"=>true, "message"=>"город удален"];
                                    else return (object) ["success"=>false, "message"=>"город с ID={$args['id']} не найдена"];
                            }
                            else{
                                return (object) ["success"=>true, "message"=>"город не может быть удалена так как содержит {$cnt} места"];
                            }
                        }
                    ],
                ];
            }
        ];
        parent::__construct($config);
    }
}