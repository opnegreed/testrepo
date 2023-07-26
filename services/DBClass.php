<?php

namespace test\services;

class DBClass
{
    public function __construct()
    {
        $dbOptions = (require __DIR__ . '/../src/settings.php')['db'];

        $connect = new \mysqli(
            $dbOptions['host'],
            $dbOptions['user'],
            $dbOptions['password'],
            $dbOptions['dbName']
        );

        if($connect->connect_error){
            die("connection failed: " .$connect->connect_error);
        }
    }

    public function create($table, $values)
    {
        $sql = "INSERT INTO ". $table. " (name, surname, date, gender, city) VALUES 
        (`".$values['name']."` , `".$values['surname']."` , `".$values['date']."` , `".$values['gender']."` , `".$values['city']."`)";

        $mysqli = new \mysqli();

        $mysqli->query($sql);
    }
}

$connect = new DBClass();

$values[] =
    [
        'name' => 'username',
        'surname' => 'userSurname',
        'date' => '1996-03-08',
        'gender' => '1',
        'city' => 'New York'
    ];

$newPost = new DBClass(create);