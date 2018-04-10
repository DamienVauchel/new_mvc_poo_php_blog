<?php

namespace Framework\Session;


/**
 * Class Session
 * @package Framework\Session
 */
class Session implements SessionInterface, \Countable, \ArrayAccess
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
        if (isset($_SESSION)) {
            return $_SESSION[$key];
        } else {
            return null;
        }
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param $key
     */
    public function delete($key)
    {
        unset($_SESSION[$key]);
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
        return isset($_SESSION[$offset]);
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