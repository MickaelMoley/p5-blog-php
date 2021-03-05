<?php

namespace App\CoreBundle\Database;

use \PDO;

class Database {

    protected static $pdo;
    protected static $config;

    public function __construct()
    {
        self::$config = yaml_parse_file('config.yaml');
    }

    public function getConfig()
    {

        return self::$config;
    }

    public function getConnection()
    {

        //Si un instance de PDOn'est pas instancié
        if(self::$pdo == null)
        {
            try {
                self::$pdo = new PDO("mysql:host=". self::$config['database']['host'] .";dbname=".self::$config['database']['db_name'].";charset=utf8",
                    self::$config['database']['user'], self::$config['database']['password'], [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS
                    ]);

                return self::$pdo;
            }
            catch (\PDOException $exception)
            {
                echo '............' . $exception->getMessage();
            }

            return false;
        }

        return self::$pdo;
    }

    public function __toString(): string
    {
        return 'self::$pdo';
    }




}
