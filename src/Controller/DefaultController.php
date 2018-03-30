<?php

namespace Controller;


use Framework\Controller\Controller;

class DefaultController extends Controller
{
    public function goToHome()
    {
        return $this->render('public/default/home.html.twig');
    }
}