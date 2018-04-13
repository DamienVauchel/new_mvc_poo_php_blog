<?php

namespace Framework\Controller;

use Framework\App\Container;
use Framework\Exception\LoginException;
use Framework\Session\FlashMessage;
use Framework\Session\Session;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Controller
 * @package Framework\Controller
 */
class Controller extends Container
{
    /**
     * @var null
     */
    protected $session = null;

    /**
     * @var null
     */
    protected $roles = null;

    /**
     * @var null
     */
    protected $token = null;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        if (isset($_SESSION) && !empty($_SESSION)) {
            $this->session = $_SESSION;
        }
    }

    /**
     * @param $path
     * @param array|null $vars
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function render($path, array $vars = null)
    {
        if ($vars !== null) {
            echo $this->getTwig()->render($path, $vars);
        } else {
            echo $this->getTwig()->render($path);
        }
    }

    /**
     * @param $name
     */
    public function redirectTo($name)
    {
        $url = $this->findPath($name);

         header("Location: http://".ROOT.$url);
    }

    /**
     * @param $name
     * @return null
     */
    public function findPath($name)
    {
        $routes = Yaml::parseFile('app/config/routes.yaml');
        $routes = $routes['routes'];

        $path = null;

        foreach ($routes as $route) {
            if ($route['name'] == $name) {
                $path = $route['path'];
            }
        }

        return $path;
    }

    /**
     * @param $input
     * @return string
     */
    public function checkInput($input)
    {
        $checkedInput = trim($input);
        $checkedInput = stripslashes($checkedInput);
        $checkedInput = htmlspecialchars($checkedInput);
        return $checkedInput;
    }

    /**
     * @param array $datas
     * @return array
     */
    public function checkDatas(array $datas)
    {
        $checkedDatas = [];
        foreach ($datas as $key => $data) {
            $checkedDatas[$key] = $this->checkInput($data);
        }

        return $checkedDatas;
    }

    /**
     * @param $title
     * @return string
     */
    public function slugify($title)
    {
        $str = strtolower(trim($title));
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = preg_replace('/-+/', "-", $str);
        $slug = rtrim($str, '-');
        return $slug;
    }

    /**
     * @param $message
     * @param $type
     * @return FlashMessage
     */
    public function setFlashMessage($message, $type)
    {
        $flashMsg = new FlashMessage(new Session());
        $flashMsg->setMessage($message, $type);

        return $flashMsg;
    }

    /**
     * @param $password
     * @return bool|string
     */
    public function encryptPw($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @param $sentPw
     * @param $dbPw
     * @return bool
     */
    public function decryptPw($sentPw, $dbPw)
    {
        return password_verify($sentPw, $dbPw);
    }

    /**
     * @return mixed
     * @throws LoginException
     */
    public function getLoggedUser()
    {
        if (!empty($_SESSION) && isset($_SESSION)) {
            if (!empty($_SESSION['loggedUser']) && isset($_SESSION['loggedUser'])) {
                $user = unserialize($_SESSION['loggedUser']);

                return $user;
            }

            throw new LoginException('No logged User');
        }

        throw new LoginException('No session');
    }

    /**
     * @return array
     * @throws LoginException
     */
    public function getLoggedUserInfos()
    {
        $loggedUser = $this->getLoggedUser();

        $username = $loggedUser->getUsername();
        $email = $loggedUser->getEmail();
        $roles = $loggedUser->getRoles();

        $user = [
            'username'          => $username,
            'email'             => $email,
            'roles'             => $roles
        ];

        return $user;
    }

    /**
     * @return mixed
     * @throws LoginException
     */
    public function getLoggedUserRoles()
    {
        $loggedUser = $this->getLoggedUser();

        return $loggedUser->getRoles();
    }

    /**
     * @return mixed
     * @throws LoginException
     */
    public function getLoggedUserUsername()
    {
        $loggedUser = $this->getLoggedUser();

        return $loggedUser->getUsername();
    }
}





























