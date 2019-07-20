<?php

require 'home_model.php';

Class User_Model extends Home_Model
{
    public function generateActivationString()
    {
        $randomSalt = '*&(*(JHjhkjnkjn9898';
        $uniqId = uniqid(mt_rand(), true);
        return md5($randomSalt . $uniqId);
    }

    public function register_user($login, $email, $password)
    {
        $sql = "SELECT 1 FROM users WHERE BINARY (login) = ? OR email = ?";
        if ($this->exists($sql, array($login, $email)))
            $_SESSION['log_error'] = 'register_wrong';
        else
            {
                $activation_string = $this->generateActivationString();
                $sql = "INSERT INTO users (login, email, password, activation_string)  VALUES (:login, :email, :password, :activation_string)";
                $parameters = array(':login' => $login, ':email' => $email, ':password' => $password, ':activation_string' => $activation_string);
                $query = $this->prepared_query($sql, $parameters);
                if ($query)
                {
                    $message = 'Go to ' . URL_WITH_INDEX_FILE . 'userArea/activate/' . $activation_string . ' to confirm registration';
                    $to = $email;
                    $subject = 'User Account Confirmation';
                    $body = $message . PHP_EOL;
                    mail($to, $subject, $body);
                    $_SESSION['log_error'] = 'register_right';
                }
                else
                    $_SESSION['log_error'] = 'register_wrong';
            }
    }

    public function activate($param)
    {
        $sql = "SELECT activation_string FROM users WHERE activation_string = ?";
        $query = $this->prepared_query($sql, array($param));
        $rows = $query->rowCount();
        if ($rows >= 1)
        {
            $sql = "UPDATE users SET status=1 WHERE activation_string = ?";
            $this->prepared_query($sql, array($param));
            $activation_string = $this->generateActivationString();
            $sql = "UPDATE users set activation_string = ? WHERE activation_string = ?";
            $query = $this->prepared_query($sql, array($activation_string, $param));
            if ($query)
                $_SESSION['log_error'] = 'activation_right';
            else
                $_SESSION['log_error'] = 'activation_wrong';
        }
        else
            $_SESSION['log_error'] = 'activation_wrong';
    }

    public function login_user($login, $password)
    {
        $sql = "SELECT login, password, status, mail_status FROM users WHERE login = ? AND password = ?";
        $query = $this->prepared_query($sql, array($login, $password));
        $rows = $query->rowCount();
        $array = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($rows >= 1 AND $array[0]['status'] == 1)
        {
            $_SESSION['logged_user'] = $login;
            $_SESSION['mail_status'] = $array[0]['mail_status'];
        }
        else
            $_SESSION['log_error'] = 'wrong';

    }

    public function mailResetPw($email)
    {

        $sql = "SELECT id,status FROM users WHERE email= ?";
        $query = $this->prepared_query($sql, array($email));
        $rows = $query->rowCount();
        $array = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($rows >= 1 AND $array[0]['status'] == 1)
        {
            $activation_string = $this->generateActivationString();
            $sql = "UPDATE users set activation_string = ? WHERE email = ?";
            $this->prepared_query($sql, array($activation_string, $email));
            $message = URL_WITH_INDEX_FILE . 'userArea/resetPw/' . $activation_string;
            $to = $email;
            $subject = 'Reset Password Confirmation';
            $body = $message . PHP_EOL;
            mail($to, $subject, $body);
        }
    }

    public function resetPw($password, $string)
    {

            $sql = "UPDATE users set password = ? WHERE activation_string = ?";
            $query = $this->prepared_query($sql, array($password, $string));
            if ($query)
            {
                $activation_string = $this->generateActivationString();
                $sql = "UPDATE users set activation_string = ? WHERE activation_string = ?";
                $this->prepared_query($sql, array($activation_string, $string));
            }
    }

    public function change_password($login, $old_password, $new_password)
    {
        $sql = "SELECT login, password, status FROM users WHERE login = ? AND password = ?";
        $query = $this->prepared_query($sql, array($login, $old_password));
        $rows = $query->rowCount();
        $array = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($rows >= 1 AND $array[0]['status'] == 1)
        {
            $sql = "UPDATE users set password = ? WHERE login = ?";
            $query = $this->prepared_query($sql, array($new_password, $login));
            if (!$query)
                $_SESSION['log_error'] = 'change_password_wrong';
        }
        else
            $_SESSION['log_error'] = 'change_password_wrong';

    }

    public function change_login($login, $new_login, $password)
    {
        $sql = "SELECT 1 FROM users WHERE login = ?";
        if ($this->exists($sql, array($new_login)))
            $_SESSION['log_error'] = 'existing_user';
        else
        {
            $sql = "SELECT login, password, status FROM users WHERE login = ? AND password = ?";
            $query = $this->prepared_query($sql, array($login, $password));
            $rows = $query->rowCount();
            $array = $query->fetchAll(PDO::FETCH_ASSOC);
            if ($rows >= 1 AND $array[0]['status'] == 1)
            {

                $sql = "UPDATE users set login = ? WHERE login = ?";
                $query = $this->prepared_query($sql, array($new_login, $login));

                if ($query)
                    $_SESSION['logged_user'] = $new_login;
                else
                    $_SESSION['log_error'] = 'change_login_wrong';
            } else
                $_SESSION['log_error'] = 'change_login_wrong';
        }
    }

    public function change_mail($login, $new_mail, $password)
    {
        $sql = "SELECT login, password, status, email FROM users WHERE login = ? AND password = ?";
        $query = $this->prepared_query($sql, array($login, $password));
        $rows = $query->rowCount();
        $array = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($rows >= 1 AND $array[0]['status'] == 1)
        {
            $sql = "SELECT email FROM users WHERE email = ?";
            $query = $this->prepared_query($sql, array($new_mail));
            $rows = $query->rowCount();
            if ($rows === 0)
            {
                $sql = "UPDATE users set email = ? WHERE login = ?";
                $query = $this->prepared_query($sql, array($new_mail, $login));
                if ($query)
                {
                    $message = 'confirm mail changed';
                    $to = $array[0]['email'];
                    $subject = 'Mail changed';
                    $body = $message . PHP_EOL;
                    mail($to, $subject, $body);
                }
                else
                    $_SESSION['log_error'] = 'change_mail_wrong';
            }
            else
                $_SESSION['log_error'] = 'existing_user';

        }
        else
            $_SESSION['log_error'] = 'change_mail_wrong';
    }


    public function unsubscribe()
    {
       $login = $_SESSION['logged_user'];
       $sql = "UPDATE users set mail_status = 0 WHERE login = ?";
        if ($query = $this->prepared_query($sql, array($login)))
            $_SESSION['mail_status'] = 0;

    }

    public function subscribe()
    {
       $login = $_SESSION['logged_user'];
       $sql = "UPDATE users set mail_status = 1 WHERE login = ?";
       if ($query = $this->prepared_query($sql, array($login)))
           $_SESSION['mail_status'] = 1;
    }
}


