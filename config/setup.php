<?php
session_start();
session_destroy();
require './database.php';

define ('CATS', '/assets/super_img/');

class db_set
{
    protected $dbh;
    protected $stmt;
    protected $sql;

    protected $DB_NAME, $DB_TYPE, $DB_HOST, $DB_USER, $DB_PASS;

    public function __construct($DB_N, $DB_T, $DB_H, $DB_U, $DB_P)
    {
        $this->DB_NAME = $DB_N;
        $this->DB_TYPE = $DB_T;
        $this->DB_HOST = $DB_H;
        $this->DB_USER = $DB_U;
        $this->DB_PASS = $DB_P;
        try
        {
            $this->dbh = new PDO("mysql:host=". $this->DB_HOST, $this->DB_USER, $this->DB_PASS);

            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            $this->sql = "DROP DATABASE IF EXISTS " . $this->DB_NAME;
            $this->dbh->exec($this->sql);
            echo "Database deleted<br>";

            $this->sql = "CREATE DATABASE " . $this->DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;";
            $this->dbh->exec($this->sql);
            echo "Database created successfully<br>";
        }
        catch(PDOException $e)
        {
            //echo $this->sql . "<br>" . $e->getMessage(); error reporting  for the development only,
            echo "Error on database creation<br>";
        }
    }

    public function db_connect()
    {
        $this->dbh = new PDO("mysql:host=". $this->DB_HOST . ";dbname=" . $this->DB_NAME . ";charset=utf8mb4", $this->DB_USER, $this->DB_PASS);
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "Connected to db<br>";
    }

    public function simple_query($query)
    {
        $this->dbh->query($query);
    }


    public function prepare($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }
    public function execute()
    {
        $this->stmt->execute();
    }

}

$db_obj = new db_set ($DB_NAME, $DB_TYPE, $DB_HOST, $DB_USER, $DB_PASS);


$db_obj->db_connect();

$sql = "CREATE TABLE users (
id INT(11) AUTO_INCREMENT NOT NULL,
login VARCHAR(45) NOT NULL PRIMARY KEY ,
password VARCHAR(255) NOT NULL,
email VARCHAR(45) NOT NULL UNIQUE,
activation_string varchar(50) NOT NULL,
status tinyint(1) NOT NULL DEFAULT '0',
mail_status tinyint(1) NOT NULL DEFAULT '1',
KEY (id))
CHARACTER SET utf8mb4 COLLATE utf8mb4_bin";
$db_obj->simple_query($sql);

$sql = "CREATE TABLE super_img 
(id INT(11) AUTO_INCREMENT PRIMARY KEY,
img_path VARCHAR(100) NOT NULL)
CHARACTER SET utf8mb4 COLLATE utf8mb4_bin";
$db_obj->simple_query($sql);

$password = hash('whirlpool', 'Jonno!1234');
$sql = "insert into users (login,password,email,activation_string,status) values ('jonno','$password','j@j','jonno',1)";
$db_obj->simple_query($sql);
$password = hash('whirlpool', 'Serry!1234');
$sql = "insert into users (login,password,email,activation_string,status) values ('serry','$password','s@s','serri',1)";
$db_obj->simple_query($sql);

$array = array(CATS . 'cat1.png', CATS . 'cat2.png', CATS . 'cat3.png', CATS . 'cat4.png');
foreach ($array as $k)
{
    $sql = "INSERT INTO super_img (img_path) VALUES ('$k')";
    $db_obj->simple_query($sql);
}

$sql = "CREATE TABLE images (
id INT(11) AUTO_INCREMENT PRIMARY KEY,
login VARCHAR(45) NOT NULL,
image LONGBLOB NOT NULL,
date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (login) REFERENCES users(login) ON UPDATE CASCADE)
CHARACTER SET utf8mb4 COLLATE utf8mb4_bin";
$db_obj->simple_query($sql);

$sql = "CREATE TABLE likes (
id_img INT(11),
login VARCHAR(45) NOT NULL,
status TINYINT(1) NOT NULL,
FOREIGN KEY (id_img) REFERENCES images(id) ON DELETE CASCADE ,
FOREIGN KEY (login) REFERENCES users(login) ON UPDATE CASCADE)
CHARACTER SET utf8mb4 COLLATE utf8mb4_bin";
$db_obj->simple_query($sql);

$sql = "CREATE TABLE comments (
id_img INT(11),
login VARCHAR(45) NOT NULL,
comment VARCHAR(255) NOT NULL,
date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (id_img) REFERENCES images(id) ON DELETE CASCADE ,
FOREIGN KEY (login) REFERENCES users(login) ON UPDATE CASCADE)
CHARACTER SET utf8mb4 COLLATE utf8mb4_bin";
$db_obj->simple_query($sql);

?>



