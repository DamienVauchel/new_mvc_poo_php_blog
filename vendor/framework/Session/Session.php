<?php

namespace Framework\Session;


class Session implements SessionInterface, \Countable, \ArrayAccess
{
    public function __construct()
    {
        session_start();
    }

    public function get($key)
    {
        if (isset($_SESSION)) {
            return $_SESSION[$key];
        } else {
            return null;
        }
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function delete($key)
    {
        unset($_SESSION[$key]);
    }

    public function count()
    {
    }

    public function offsetExists($offset)
    {
        return isset($_SESSION[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        return $this->delete($offset);
    }
}