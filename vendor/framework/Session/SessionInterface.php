<?php
namespace Framework\Session;

/**
 * Interface SessionInterface
 * @package Framework\Session
 */
interface SessionInterface
{
    /**
     * @param $key
     * @return mixed
     */
    public function get($key);

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value);

    /**
     * @param $key
     * @return mixed
     */
    public function delete($key);
}
