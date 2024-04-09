<?php

namespace App\infrastructure\database\contracts;

interface DatabaseContextInterface
{
    public function commit():void;
    public function rollback():void;
    public function startStatement():void;
    public function save(string $tableName, array $params):void;
    public function getLastInsertID():int;
    public function select(string $tableName, array $columns, array $params): ?array;
    public function delete(string $tableName, int $id):void;
    public function update(string $tableName, array $params, int $id):void;
}