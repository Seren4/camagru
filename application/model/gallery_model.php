<?php
require 'user_model.php';

Class Gallery_Model extends User_Model
{
    public function show_user_gallery()
    {
        $sql = "SELECT id,image FROM images WHERE login = ? ORDER BY date DESC ";
        $query = $this->prepared_query($sql, array($_SESSION['logged_user']));
        $user_img = $query->fetchAll(PDO::FETCH_ASSOC);
        return ($user_img);
    }

    public function getImages($offset, $rowsperpage)
    {
        $sql = "SELECT * from images order by date DESC LIMIT ?, ? ";
        $query = $this->db->prepare($sql);
        $query->bindValue(1, $offset, PDO::PARAM_INT);
        $query->bindValue(2, $rowsperpage, PDO::PARAM_INT);
        $query->execute();

        return ($query);
    }

    public function getImagesRows()
    {
        $sql = "SELECT COUNT(*) FROM images";
        $query = $this->ft_query($sql);
        $n = $query->fetchAll(PDO::FETCH_NUM);
        return $n[0][0];
    }


    public function add_like($id_img)
    {
        $login = $_SESSION['logged_user'];
        $sql = "select status FROM likes WHERE id_img = :id_img AND login = :login";
        $parameters = array(':id_img' => $id_img, ':login' => $login);
        $query = $this->prepared_query($sql, $parameters);

        $assoc = $query->fetchAll(PDO::FETCH_BOTH);
        if ($assoc)
        {
            $stat = $assoc[0]['status'] == 1 ? 0 : 1;
            $sql = "update likes set status = :stat WHERE id_img = :id_img AND login = :login";
            $parameters = array(':stat' => $stat, ':id_img' => $id_img, ':login' => $login);
            $this->prepared_query($sql, $parameters);


        }
        else
        {
            $sql = "insert into likes (id_img,login,status) values (:id, :login, :status)";
            $parameters = array(':id' => $id_img,':login' => $login, ':status' => 1);
            $this->prepared_query($sql, $parameters);
        }
    }


        public function total_likes($id_img)
    {
        $sql = "select count(*) FROM likes WHERE id_img = :id_img AND status = :status";
        $parameters = array(':id_img' => $id_img,':status' => 1);
        $query = $this->prepared_query($sql, $parameters);
        $count = $query->fetchAll(PDO::FETCH_NUM);
        return ($count[0][0]);
    }


    function add_comment($id_img, $comment)
    {
        $login = $_SESSION['logged_user'];
        $sql = "insert into comments (id_img,login,comment) values (:id, :login, :comment)";
        $parameters = array(':id' => $id_img,':login' => $login, ':comment' => $comment);
        $query= $this->prepared_query($sql, $parameters);
        if ($query)
        {
            $sql = "select login FROM images WHERE id = :id_img";
            $parameters = array(':id_img' => $id_img);
            $query= $this->prepared_query($sql, $parameters);
            $array = $query->fetchAll(PDO::FETCH_ASSOC);
            $login_to = $array[0]['login'];
            if ($login_to)
            {
                $sql = "select email, mail_status FROM users WHERE login = ?";
                $query= $this->prepared_query($sql, array($login_to));
                $array = $query->fetchAll(PDO::FETCH_ASSOC);
                $mail_status = $array[0]['mail_status'];
                if ($mail_status == 1)
                {
                    $to = $array[0]['email'];
                    if ($to)
                    {
                        $message = 'User '.$login.' commented your photo in date '.date("m/d/y h:m A", time());
                        $subject = 'Photo comment';
                        $body = $message . PHP_EOL;
                        mail($to, $subject, $body);
                    }
                }
            }
        }
    }

    public function total_comm($id_img)
    {
        $sql = "select count(*) FROM comments WHERE id_img = :id_img";
        $parameters = array(':id_img' => $id_img);
        $query= $this->prepared_query($sql, $parameters);
        $count = $query->fetchAll(PDO::FETCH_NUM);
        return ($count[0][0]);
    }


    public function show_comments($id_img)
    {
        $sql = "select login,comment,date FROM comments WHERE id_img = :id_img order by date DESC";
        $parameters = array(':id_img' => $id_img);
        $query= $this->prepared_query($sql, $parameters);
        $array = $query->fetchAll(PDO::FETCH_ASSOC);
        return ($array);
    }
}