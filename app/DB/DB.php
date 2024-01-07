<?php

namespace App\DB;

use PDO;
use PDOException;

class DB
{
    private static object $instance;

    public static function getInstance(){
        try {
            if(!isset(self::$instance)){
                self::$instance = new PDO('mysql:host=' . $_ENV['BD_HOST'] . '; dbname=' . $_ENV['BD_NAME'] . ';', $_ENV['BD_USER'], $_ENV['BD_PASSWORD']);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return self::$instance;
        } catch (PDOException $exception) {
            throw new PDOException($exception->getMessage());
        }
    }
}