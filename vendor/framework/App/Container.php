<?php

namespace Framework\App;

class Container
{
    protected function getTwigParams()
    {
        $twigParams = yaml_parse_file('app/config/twig.yaml');
        return $twigParams['twig'];
    }

    protected function getTwig()
    {
        $params = $this->getTwigParams();
        $loader = new \Twig_Loader_Filesystem(array($params['views_folder']));

        return new \Twig_Environment($loader);
    }
}