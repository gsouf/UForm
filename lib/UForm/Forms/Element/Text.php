<?php

namespace UForm\Forms\Element;

class Text extends Input{
    public function __construct($name, $attributes = null, $validators = null, $filters = null) {
        parent::__construct("text", $name, $attributes, $validators, $filters);
    }
}