<?php

namespace Controller;

use Framework\Controller\Controller;

class AdminController extends Controller
{
    public function indexaction()
    {
        return $this->render('admin/default/panel.html.twig');
    }
}