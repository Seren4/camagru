<?php

class userArea extends Controller
{
    public function index()
    {
        $_SESSION['currpage'] = 1;
        require APP . 'views/_templates/header.php';
        require APP . 'views/user/userArea.php';
        require APP . 'views/_templates/footer.php';

        if (!empty($_SESSION['log_error']))
        {
            if ($_SESSION['log_error'] === 'change_password_wrong')
            {
                ?><script>document.getElementById('new_pw_form_error').style.display = "block";
                openFormModal('new_pw_form');</script>
                <?php unset($_SESSION['log_error']);
            }
            else if ($_SESSION['log_error'] === 'change_login_wrong' OR $_SESSION['log_error'] === 'existing_user')
            {
                if ($_SESSION['log_error'] === 'change_login_wrong') : ?>
                    <script>document.getElementById('new_login_form_error').style.display = "block";</script>
                <?php else : ?>
                    <script>document.getElementById('new_login_form_error2').style.display = "block";</script>
                <?php endif; ?>
                <script>openFormModal('new_login_form'); </script><?php
                unset($_SESSION['log_error']);
            }
            else if ($_SESSION['log_error'] === 'change_mail_wrong')
            {
                ?><script>document.getElementById('new_mail_form_error').style.display = "block";
                openFormModal('new_mail_form'); </script><?php
                unset($_SESSION['log_error']);
            }

        }
    }

    public function login()
    {
        require APP . 'views/_templates/header.php';
        require APP . 'views/user/forms.php';
        require APP . 'views/_templates/footer.php'; ?>
        <script> openFormModal('login_form');</script><?php
        unset($_SESSION['log_error']);
    }

    public function register()
    {
        require APP . 'views/_templates/header.php';
        require APP . 'views/user/forms.php';
        require APP . 'views/_templates/footer.php';
        ?><script> openFormModal('register_form'); </script><?php
        unset($_SESSION['log_error']);
    }

    public function logout()
    {
        session_destroy();
        header('location: ' . URL_WITH_INDEX_FILE . 'home/index');
    }


    public function activate($param = null)
    {
        if (!ctype_xdigit($param) OR !$param)
        {
            header('location: ' . URL_WITH_INDEX_FILE . 'home/index');
        }
        else if (ctype_xdigit($param))
        {
            $this->model->activate($param);
            header('location: ' . URL_WITH_INDEX_FILE . 'home/index');
        }

    }


    public function resetPw($string = null)
    {
        if (!ctype_xdigit($string) OR !$string)
        {
            header('location: ' . URL_WITH_INDEX_FILE . 'home/index');

        }
        else
        {
            require APP . 'views/_templates/header.php';
            require APP . 'views/user/forms.php';
            require APP . 'views/_templates/footer.php';
            ?><script> openFormModal('reset_pw_form'); </script><?php
        }

    }


    public function unsubscribe()
    {
        $this->model->unsubscribe();
    }
    public function subscribe()
    {
        $this->model->subscribe();
    }

    public function user_form_validate()
    {
        $clean = array();
        $login_pattern = '/^[a-zA-Z0-9_]{5,20}$/';
        $email_pattern = '/^[^@\s<&>]+@([-a-z0-9]+\.)+[a-z]{2,}$/i';
        $password_pattern = '/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/';
        switch ($_POST['form'])
        {
            case 'login':
                $allowed = array();
                $allowed[] = 'form';
                $allowed[] = 'login';
                $allowed[] = 'password';
                $sent = array_keys($_POST);
                if ($allowed == $sent)
                {
                    $post_login = trim($_POST['login']);
                    $post_pass = trim($_POST['password']);
                    if (preg_match($login_pattern, $post_login) AND preg_match($password_pattern, $post_pass))
                    {
                        $clean['login'] = $post_login;
                        $clean['password'] = hash('whirlpool', $post_pass);
                        $this->model->login_user($clean['login'], $clean['password']);
                    }
                    else
                        $_SESSION['log_error'] = 'wrong';
                }
                break;

            case 'register':
                $allowed = array();
                $allowed[] = 'form';
                $allowed[] = 'login';
                $allowed[] = 'email';
                $allowed[] = 'password';
                $sent = array_keys($_POST);
                if ($allowed == $sent)
                {
                    $post_login = trim($_POST['login']);
                    $post_email = trim($_POST['email']);
                    $post_pass = trim($_POST['password']);
                    if (preg_match($login_pattern, $post_login) AND preg_match($email_pattern, $post_email)
                        AND preg_match($password_pattern, $post_pass))
                    {
                        $clean['login'] = $post_login;
                        $clean['email'] = $post_email;
                        $clean['password'] = hash('whirlpool', $post_pass);
                        $this->model->register_user($clean['login'], $clean['email'], $clean['password']);
                    }
                    else
                        $_SESSION['log_error'] = 'register_wrong';
                }
                break;

            case 'mail_reset_pw':
                $allowed = array();
                $allowed[] = 'form';
                $allowed[] = 'email';
                $sent = array_keys($_POST);
                if ($allowed == $sent)
                {
                    $post_email = trim($_POST['email']);
                    if (preg_match($email_pattern, $post_email))
                    {
                        $clean['email'] = $post_email;
                        $this->model->mailResetPw($clean['email']);
                        $_SESSION['log_error'] = 'register_right';
                    }
                }
                break;

            case 'reset_pw':
                $allowed = array();
                $allowed[] = 'form';
                $allowed[] = 'password';
                $allowed[] = 'string';
                $sent = array_keys($_POST);
                if ($allowed == $sent)
                {
                    $post_pass = trim($_POST['password']);
                    $post_string = trim($_POST['string']);
                    if (preg_match($password_pattern, $post_pass) AND ctype_xdigit($post_string))
                    {
                        $clean['password'] = hash('whirlpool', $post_pass);
                        $this->model->resetPw($clean['password'], $post_string);
                    }
                }
                break;

            case 'change_pw':
                $allowed = array();
                $allowed[] = 'form';
                $allowed[] = 'login';
                $allowed[] = 'old_password';
                $allowed[] = 'new_password';
                $sent = array_keys($_POST);
                if ($allowed == $sent)
                {
                    $post_login = trim($_POST['login']);
                    $post_old_pass = trim($_POST['old_password']);
                    $post_new_pass = trim($_POST['new_password']);

                    if (preg_match($login_pattern, $post_login) AND preg_match($password_pattern, $post_old_pass)
                        AND preg_match($password_pattern, $post_new_pass))
                    {
                        $clean['login'] = $post_login;
                        $clean['old_password'] = hash('whirlpool', $post_old_pass);
                        $clean['new_password'] = hash('whirlpool', $post_new_pass);
                        $this->model->change_password($clean['login'], $clean['old_password'], $clean['new_password']);
                    }
                    else
                        $_SESSION['log_error'] = 'change_password_wrong';
                }
                break;


            case 'change_login':
                $allowed = array();
                $allowed[] = 'form';
                $allowed[] = 'login';
                $allowed[] = 'new_login';
                $allowed[] = 'password';
                $sent = array_keys($_POST);
                if ($allowed == $sent)
                {
                    $post_login = trim($_POST['login']);
                    $post_new_login = trim($_POST['new_login']);
                    $post_pass = trim($_POST['password']);

                    if (preg_match($login_pattern, $post_login) AND preg_match($login_pattern, $post_new_login)
                        AND preg_match($password_pattern, $post_pass))
                    {
                        $clean['login'] = $post_login;
                        $clean['new_login'] = $post_new_login;
                        $clean['password'] = hash('whirlpool', $post_pass);
                        $this->model->change_login($clean['login'], $clean['new_login'], $clean['password']);
                    }
                    else
                        $_SESSION['log_error'] = 'change_login_wrong';
                }
                break;

            case 'change_mail':
                $allowed = array();
                $allowed[] = 'form';
                $allowed[] = 'login';
                $allowed[] = 'new_mail';
                $allowed[] = 'password';
                $sent = array_keys($_POST);
                if ($allowed == $sent)
                {
                    $post_login = trim($_POST['login']);
                    $post_new_mail = trim($_POST['new_mail']);
                    $post_pass = trim($_POST['password']);

                    if (preg_match($login_pattern, $post_login) AND preg_match($email_pattern, $post_new_mail)
                        AND preg_match($password_pattern, $post_pass))
                    {
                        $clean['login'] = $post_login;
                        $clean['new_mail'] = $post_new_mail;
                        $clean['password'] = hash('whirlpool', $post_pass);
                        $this->model->change_mail($clean['login'], $clean['new_mail'], $clean['password']);
                    }
                    else
                        $_SESSION['log_error'] = 'change_mail_wrong';
                }
                break;

            case 'add_comment':
                $allowed = array();
                $allowed[] = 'form';
                $allowed[] = 'idImg';
                $allowed[] = 'comment';
                $sent = array_keys($_POST);
                if ($allowed == $sent)
                {
                    $post_idImg = trim($_POST['idImg']);
                    $post_comment = trim($_POST['comment']);
                    if (ctype_digit($post_idImg))
                    {
                        $clean['idImg'] = $post_idImg;
                        $clean['comment'] = htmlentities($post_comment, ENT_QUOTES);
                        $this->model->add_comment($clean['idImg'], $clean['comment']);
                    }
                }
                break;

        }
    }
}