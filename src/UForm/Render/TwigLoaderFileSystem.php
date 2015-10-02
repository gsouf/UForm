<?php

namespace UForm\Render;

class TwigLoaderFileSystem extends \Twig_Loader_Filesystem
{
    public function normalizeName($name)
    {
        if (substr($name, -5) !== ".twig") {
            $name .= ".twig";
        }

        return parent::normalizeName($name); // TODO: Change the autogenerated stub
    }
}