<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . '/vendor/autoload.php';

use App\Cors;
use App\DB;
use App\Types;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;

new cors();
try {
    // Настройки подключения к БД
    $config = [
        'host' => 'db_host',
        'database' => 'db_name',
        'username' => 'db_user',
        'password' => 'db_user_passwd'
    ];

    // Инициализация соединения с БД
    DB::init($config);
    DB::select('SET NAMES utf8');

    // Получение запроса
    $rawInput = file_get_contents('php://input');
    $input = json_decode($rawInput, true);
    $query = $input['query'];

    // Получение переменных запроса
    $variables = isset($input['variables'])? $input['variables']:null; 
    

    // Создание схемы
    $schema = new Schema([
        'query' => Types::query(),
        'mutation' => Types::mutation()
    ]);

    // Выполнение запроса
    $result = GraphQL::executeQuery($schema, $query, null, null, $variables)->toArray();
    // $result = ['test'=>'test'];
} catch (\Exception $e) {
    $result = [
        'error' => [
            'message' => $e->getMessage()
        ]
    ];
}

// Вывод результата
///echo $result;
echo json_encode($result);