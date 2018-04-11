<?php
// Singleton

namespace Framework\App;

use Symfony\Component\Yaml\Yaml;

/**
 * Class Config
 * @package Framework\App
 */
class Config
{
    /**
     * @var mixed
     */
    private $parameters;
    /**
     * @var
     */
    private static $instance;

    /**
     * Config constructor.
     */
    public function __construct()
    {
        $this->parameters = Yaml::parseFile('app/config/parameters.yaml');
    }

    /**
     * @return Config
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Config();
        }

        return self::$instance;
    }

    /**
     * @param $key
     * @return null
     */
    public function get($key)
    {
        if (!isset($this->parameters[$key])) {
            return null;
        }

        return $this->parameters[$key];
    }
}