<?php

namespace App\infrastructure\database\implemention;

use App\infrastructure\database\contracts\DatabaseContextInterface;
use App\infrastructure\database\exception\ExceptionNotExistsParams;
use App\infrastructure\database\types\DatabaseParams;
use App\infrastructure\database\types\DatabaseParamsSelect;
use App\infrastructure\database\types\DatabaseParamsTypeToPdo;
use PDO;

use function App\infrastructure\database\sqlHelper\columnsFormatMysql;
use function App\infrastructure\database\sqlHelper\conditionFormatMysql;
use function App\infrastructure\database\sqlHelper\paramsFormatInsertMysql;
use function App\infrastructure\database\sqlHelper\paramsFormatUpdateMysql;

require_once __DIR__ . '/../sqlHelper/columnsFormatMysql.php';
require_once __DIR__ . '/../sqlHelper/conditionFormatDataMysql.php';
require_once __DIR__ . '/../sqlHelper/conditionFormatMysql.php';
require_once __DIR__ . '/../sqlHelper/paramsFormatInsertMysql.php';
require_once __DIR__ . '/../sqlHelper/paramsFormatUpdateMysql.php';

class DatabaseContextMysql implements DatabaseContextInterface
{
    private ?PDO $connection  = null;

    public function __construct()
    {

    }

    private function createPDO():void
    {
        $connection = new PDO(
            "mysql:host={$_ENV['BD_HOST']};
                 dbname={$_ENV['BD_NAME']}",
            $_ENV['BD_USER'],
            $_ENV['BD_PASSWORD']);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connection = $connection;
    }

    public function commit(): void
    {
        if($this->connection?->inTransaction()){
            $this->connection->commit();
        }
    }

    public function rollback(): void
    {
        if($this->connection?->inTransaction()){
            $this->connection->rollBack();
        }
    }

    public function startStatement(): void
    {
        $this->createPDO();

        $this->connection?->beginTransaction();
    }


    /**
     * @param string $tableName
     * @param array<DatabaseParams> $params
     * @return void
     * @throws ExceptionNotExistsParams
     */
    public function save(string $tableName, array $params): void
    {
        if(count($params) <= 0){
            throw new ExceptionNotExistsParams("SQL INSERT error in params");
        }

        $sql = "INSERT INTO $tableName ";
        $sql .= paramsFormatInsertMysql(false, $params);
        $sql .= paramsFormatInsertMysql(true, $params);

        $stmt = $this->connection->prepare($sql);

        foreach ($params as $param){
            $stmt->bindParam(
                param:":$param->name",
                var: $param->value,
                type: DatabaseParamsTypeToPdo::convert($param->type),
                maxLength: $param->length
            );
        }

        $stmt->execute();
    }



    public function getLastInsertID(): int
    {
        return $this->connection->lastInsertId();
    }


    /**
     * @param string $tableName
     * @param array<string> $columns
     * @param array<DatabaseParamsSelect> $params
     * @return array|null
     */
    public function select(
        string $tableName,
        array  $columns,
        array  $params
    ): ?array
    {
        $sql = "SELECT ";
        $sql .= columnsFormatMysql($columns) . " FROM {$tableName} ";
        $sql .= conditionFormatMysql($params);

        $stmt = $this->connection->prepare($sql);
        foreach ($params as $param){
            $stmt->bindValue(":$param->name", $param->value);
        }
        $stmt->execute();

        $reponse = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return is_bool($reponse) ? null : $reponse;
    }

    public function delete(string $tableName, int $id): void
    {
        $sql = "DELETE FROM $tableName WHERE ID = :ID LIMIT 1";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":ID", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * @throws ExceptionNotExistsParams
     */
    public function update(string $tableName, array $params, int $id): void
    {
        if(count($params) <= 0){
            throw new ExceptionNotExistsParams("SQL INSERT error in params");
        }

        $sql = "UPDATE $tableName ";
        $sql .= paramsFormatUpdateMysql($params);
        $sql .= " WHERE id = :id LIMIT 1";

        $stmt = $this->connection->prepare($sql);

        foreach ($params as $param){
            $stmt->bindParam(
                param:":$param->name",
                var: $param->value,
                type: DatabaseParamsTypeToPdo::convert($param->type),
                maxLength: $param->length
            );
        }
        $stmt->bindParam(param:":id", var: $id, type: PDO::PARAM_INT);

        $stmt->execute();
    }
}