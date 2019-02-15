<?php

namespace ClementPatigny\Controller;

abstract class AppController {
    protected $twig;

    public function __construct() {
        $loader = new \Twig_Loader_Filesystem(ROOT . '/view');
        $twig = new \Twig_Environment($loader, [
            'cache' => false // ROOT . '/tmp'
        ]);

        $this->twig = $twig;
    }
}
