<?php

namespace Framework\Controller;

use Framework\App\Container;

class Controller extends Container
{
    public function render($path, array $vars = null)
    {
        if ($vars !== null) {
            echo $this->getTwig()->render($path, $vars);
        } else {
            echo $this->getTwig()->render($path);
        }
    }
}