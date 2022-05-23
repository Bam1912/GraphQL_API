<?php

namespace App\Type\Query;

use App\DB;
use App\Types;
use GraphQL\Type\Definition\ObjectType;

/**
 * Тип Store для GraphQL
 */
class StorageType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Хранилище',
            'fields' => function() {
                return [
                    'id' => [
                        'type' => Types::id(),
                        'description' => 'Идентификатор хранилища'
                    ],
                    'files' => [
                        'type' => Types::listOf(Types::file()),
                        'description' => 'Список файлов',
                        'resolve' => function ($root) {
                            return DB::select("SELECT f.* FROM files f JOIN storage_to_file s ON s.file_id = f.id WHERE s.storage_id = {$root->id}");
                        }
                    ],
                    'filesCount' => [
                        'type' => Types::int(),
                        'description' => 'Количество файлов',
                        'resolve' => function ($root) {
                            return DB::affectingStatement("SELECT f.* FROM files f JOIN storage_to_file s ON s.file_id = f.id WHERE s.storage_id = {$root->id}");
                        }
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }
}