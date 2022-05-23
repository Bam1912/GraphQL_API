<?php

//declare(strict_types=1);

use App\DB;

require __DIR__.'/vendor/autoload.php';

$to = $email = "info@levelfive.ru";
$config = [
    'host' => 'localhost',
    'database' => 'levelfive_captur',
    'username' => 'levelfive_bam',
    'password' => 'sdy5akym'
];
    // Инициализация соединения с БД
    DB::init($config);
    DB::select('SET NAMES utf8');
$data = DB::selectOne("SELECT * from landingformdata WHERE id = 8");
var_dump($data->data);
$message = "Поступила новая заявка<hr>";
if(!empty($data->data))
                                    foreach(json_decode($data->data) as $key=>$val)
                                        $message .=  "<br>".$key.' => '.$val;

print_r($message);
// var_dump(mail($email, $subject, $message,$headers));

?>