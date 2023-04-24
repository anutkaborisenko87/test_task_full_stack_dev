<?php

namespace testFullStackDev\BaseClasses;

class Controller
{
    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }
}