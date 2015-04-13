<?php

namespace UForm\Forms\Group;

use UForm\Forms\Element\Group;
use UForm\Tag;

class Tab extends NamedGroup{

    public function __construct($name = null, $elements = null)
    {
        parent::__construct("div", $name, $elements);
    }

}