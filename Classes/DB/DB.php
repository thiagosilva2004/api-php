<?php

namespace DB;

use PDO;
use PDOException;

require_once __DIR__ . '/../../config.php';

class DB
{
    private static object $instance;

    public static function getInstance(){
        try {
            if(!isset(self::$instance)){
                self::$instance = new PDO('mysql:host=' . BD_HOST . '; dbname=' . BD_NAME . ';', BD_USER, BD_PASSWORD);
            }
            return self::$instance;
        } catch (PDOException $exception) {
            throw new PDOException($exception->getMessage());
        }
    }
}