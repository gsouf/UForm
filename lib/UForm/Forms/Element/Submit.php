<?php

namespace UForm\Forms\Element;

class Submit extends Input{
    public function __construct($name, $attributes = null, $validators = null, $filters = null) {
        parent::__construct("submit", $name, $attributes, $validators, $filters);
    }
}