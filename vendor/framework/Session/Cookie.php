<?php

namespace Framework\Session;

/**
 * Class Cookie
 * @package Framework\Session
 */
class Cookie implements \Countable, \ArrayAccess
{
    /**
     * Session constructor.
     */
    public function __construct()
    {
        session_start();
    }

    /**
     * @param $key
     * @return null
     */
    public function get($key)
    {
        if (isset($_COOKIE)) {
            return $_COOKIE[$key];
        } else {
            return null;
        }
    }

    /**
     * @param $key
     * @param $value
     * @param $time
     */
    public function set($key, $value, $time)
    {
        return setcookie($key, $value, $time);
    }

    /**
     * @param $key
     */
    public function delete($key)
    {
        unset($_COOKIE[$key]);
    }

    /**
     * @return int|void
     */
    public function count()
    {
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($_COOKIE[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        return $this->delete($offset);
    }
}