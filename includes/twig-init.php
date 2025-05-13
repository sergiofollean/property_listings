<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

function rel_get_twig()
{
    static $twig;

    if (! $twig) {
        $loader = new FilesystemLoader(REL_PLUGIN_DIR . 'templates');
        $twig = new Environment($loader, [
            'cache' => false,
            'auto_reload' => true,
        ]);
    }


    return $twig;
}
