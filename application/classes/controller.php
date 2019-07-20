<?php
session_start();
date_default_timezone_set('Europe/Paris');

class Controller
{
    public $db = null;
    public $model = null;

    /**
     * When a controller is created, opens a database connection too that can be used by multiple models.
     */
    function __construct($DB_N, $DB_T, $DB_H, $DB_U, $DB_P)
    {
        $this->openDatabaseConnection($DB_N, $DB_T, $DB_H, $DB_U, $DB_P);
        $this->loadModel();
    }

    private function openDatabaseConnection($DB_N, $DB_T, $DB_H, $DB_U, $DB_P)
    {
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        $this->db = new PDO($DB_T . ':host=' . $DB_H . ';dbname=' . $DB_N, $DB_U, $DB_P, $options);
    }

    public function loadModel()
    {
        require APP . '/model/model.php';
        $this->model = new Model($this->db);
    }
}
