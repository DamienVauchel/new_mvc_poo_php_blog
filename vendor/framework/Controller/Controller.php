<?php

namespace Framework\Controller;


class Controller
{
    public function getTwigParams()
    {
        $twigParams = yaml_parse_file('app/config/twig.yaml');
        return $twigParams['twig'];
    }

    public function getTwig()
    {
        $params = $this->getTwigParams();
        $loader = new \Twig_Loader_Filesystem(array($params['views_folder']));

        return new \Twig_Environment($loader);
    }

    public function render($path, array $vars = null)
    {
        if ($vars !== null) {
            echo $this->getTwig()->render($path, $vars);
        } else {
            echo $this->getTwig()->render($path);
        }
    }
}