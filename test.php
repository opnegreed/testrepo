<?php
$config = require_once('config.php');

$mysqli = new mysqli($config['host'], $config['user'], $config['password'], $config['dbName']);

$result = $mysqli->query("SELECT `name` FROM test_table WHERE id = 1");

$row = $result->fetch_assoc();

print_r($row);