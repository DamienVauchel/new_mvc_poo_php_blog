<?php

namespace Framework\HTTP;


/**
 * Class Response
 * @package Framework\HTTP
 */
class Response
{
    /**
     * @var
     */
    protected $page;

    /**
     * @param $header
     */
    public function addHeader($header)
    {
        header($header);
    }

    /**
     * @param $location
     */
    public function redirect($location)
    {
        header('Location: '.$location);
        exit;
    }

    /**
     *
     */
    public function redirect404()
    {

    }

    /**
     * @param $name
     * @param string $value
     * @param int $expire
     * @param null $path
     * @param null $domain
     * @param bool $secure
     * @param bool $httpOnly
     */
    public function setCookie($name, $value = '', $expire = 0, $path = null, $domain = null, $secure = false, $httpOnly = true)
    {
        setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
    }
}