<?php

namespace Controller;

class Home
{

    function index()
    {
        ob_start();
        include 'Views/home/index.phtml';
        $content = ob_get_clean();
        return $content;
    }
}
