<?php

namespace Backend\Controllers;

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        return $this->dispatcher->forward("login");
    }
}
