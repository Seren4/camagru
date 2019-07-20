<?php

class Application
{
    private $url_controller = null;
    private $url_action = null;
    public $url_params = array();

    public function __construct($DB_N, $DB_T, $DB_H, $DB_U, $DB_P)
    {
        $this->getUrlFields();
        if (!$this->url_controller)
        {
            require APP . 'controllers/home.php';
            $page = new Home($DB_N, $DB_T, $DB_H, $DB_U, $DB_P);
            $page->index();
        }
        elseif (file_exists(APP . 'controllers/' . $this->url_controller . '.php'))
        {
            require APP . 'controllers/' . $this->url_controller . '.php';
            $this->url_controller = new $this->url_controller($DB_N, $DB_T, $DB_H, $DB_U, $DB_P);
            if (method_exists($this->url_controller, $this->url_action))
            {
                if(!empty($this->url_params))
                    call_user_func_array(array($this->url_controller, $this->url_action), $this->url_params);
                else
                    $this->url_controller->{$this->url_action}();
            }
            else
                $this->url_controller->index();
        }
        else
            {
                require APP . 'controllers/errors.php';
                $page = new Errors($DB_N, $DB_T, $DB_H, $DB_U, $DB_P);
                $page->index();
            }
    }

    private function getUrlFields()
    {
        $url = explode('/', $_SERVER['REQUEST_URI']);
        $url = array_diff($url, array('', 'index.php'));
        $url = array_values($url);

        $this->url_controller = isset($url[0]) ? $url[0] : null;
        $this->url_action = isset($url[1]) ? $url[1] : null;
        unset($url[0], $url[1]);
        $this->url_params = array_values($url);
    }
}
