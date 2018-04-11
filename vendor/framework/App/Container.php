<?php

namespace Framework\App;

use Symfony\Component\Yaml\Yaml;

/**
 * Class Container
 * @package Framework\App
 */
class Container
{
    /**
     * @return mixed
     */
    protected function getTwigParams()
    {
        $twigParams = Yaml::parseFile('app/config/twig.yaml');
        return $twigParams['twig'];
    }

    /**
     * @return \Twig_Environment
     */
    protected function getTwig()
    {
        $params = $this->getTwigParams();
        $loader = new \Twig_Loader_Filesystem(array($params['views_folder']));
        $twig = new \Twig_Environment($loader, array(
            'debug'                 => true
        ));
        $twig->addExtension(new \Twig_Extension_Debug());

        return $twig;
    }
}