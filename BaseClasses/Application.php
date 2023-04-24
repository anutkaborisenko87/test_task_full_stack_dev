<?php

namespace testFullStackDev\BaseClasses;

use Exception;

class Application
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @throws Exception
     */
    public function run()
    {
        Router::match($this->request->get_uri(), $this->request->get_method());
    }
}