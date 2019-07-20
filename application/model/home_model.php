<?php

require 'db_model.php';

Class Home_Model extends DB_Model
{
    public function show_super_img()
    {
        $sql = "SELECT * FROM super_img";
        $obj = $this->ft_query($sql);
        return $obj->fetchAll(PDO::FETCH_ASSOC);

    }

    public function image_save($image)
    {
        $login = $_SESSION['logged_user'];  
        $sql = "INSERT INTO images (login, image) VALUES (:login, :image)";
        $parameters = array(':login' => $login, ':image' => $image);
        $this->prepared_query($sql, $parameters);
        header('location: ' . URL_WITH_INDEX_FILE . 'home/index');
    }

    public function deleteImg($index, $login)
    {
        $sql = "DELETE FROM images WHERE id = :id AND login = :login";
        $parameters = array(':id' => $index, ':login' => $login);
        $this->prepared_query($sql, $parameters);

        header('location: ' . URL_WITH_INDEX_FILE . 'home/index');
    }
}