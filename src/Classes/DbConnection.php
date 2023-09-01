<?php

namespace Shortener\Elena;

use PDO;
use PDOException;

class DbConnection
{
    private string $server;
    private string $username;
    private string $password;
    private string $dbname;

    function connect(): PDO
    {
        $this->server = HOST;
        $this->username = USERNAME;
        $this->password = PASSWORD;
        $this->dbname = DB_NAME;

        try {
            $dsn = "mysql:host=" . $this->server . ";dbname=" . $this->dbname;
            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {   
            $message= PHP_EOL .$e->getMessage() . 'with code ' . $e->getCode();
            error_log($message, 3, APP_DIR ."error-log.php");
            throw new ConnectionFailedException(); 
        }
    }
}
