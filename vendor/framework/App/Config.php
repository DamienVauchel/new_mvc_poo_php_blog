<?php
// Singleton

namespace Framework\App;

class Config
{
    private $parameters;
    private static $instance;

    public function __construct()
    {
        $this->parameters = yaml_parse_file('app/config/parameters.yaml');
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Config();
        }

        return self::$instance;
    }

    public function get($key)
    {
        if (!isset($this->parameters[$key])) {
            return null;
        }

        return $this->parameters[$key];
    }
}