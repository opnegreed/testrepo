<?php

class DBClass{

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $config = require_once('config.php');

        $conn = new mysqli($config['host'], $config['user'], $config['password'], $config['dbName']);

        return $conn;
    }

    public function create(){

        $sql = mysqli_query(`SELECT * FROM test_table`);

        $result = $sql->fetch_assoc();

        print_r($result);
    }
}

$example = new DBClass();

$example->create();