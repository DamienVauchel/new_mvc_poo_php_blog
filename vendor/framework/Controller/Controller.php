<?php

namespace Framework\Controller;

use Framework\App\Container;
use Framework\Session\FlashMessage;
use Framework\Session\Session;

class Controller extends Container
{
    protected $session = null;

    public function __construct()
    {
        if (isset($_SESSION) && !empty($_SESSION)) {
            $this->session = $_SESSION;
        }
    }

    public function render($path, array $vars = null)
    {
        if ($vars !== null) {
            echo $this->getTwig()->render($path, $vars);
        } else {
            echo $this->getTwig()->render($path);
        }
    }

    public function redirectTo($name)
    {
        $url = $this->findPath($name);

         header("Location: http://".ROOT.$url);
    }

    public function findPath($name)
    {
        $routes = yaml_parse_file('app/config/routes.yaml');
        $routes = $routes['routes'];

        $path = null;

        foreach ($routes as $route) {
            if ($route['name'] == $name) {
                $path = $route['path'];
            }
        }

        return $path;
    }

    public function checkInput($input)
    {
        $checkedInput = trim($input);
        $checkedInput = stripslashes($checkedInput);
        $checkedInput = htmlspecialchars($checkedInput);
        return $checkedInput;
    }

    public function checkDatas(array $datas)
    {
        $checkedDatas = [];
        foreach ($datas as $key => $data) {
            $checkedDatas[$key] = $this->checkInput($data);
        }

        return $checkedDatas;
    }

    public function slugify($title)
    {
        $str = strtolower(trim($title));
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = preg_replace('/-+/', "-", $str);
        $slug = rtrim($str, '-');
        return $slug;
    }

    public function setFlashMessage($message, $type)
    {
        $flashMsg = new FlashMessage(new Session());
        $flashMsg->setMessage($message, $type);

        return $flashMsg;
    }
}