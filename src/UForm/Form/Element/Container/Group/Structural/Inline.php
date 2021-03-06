<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Container\Group\Structural;

use UForm\Form\Element;
use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Container\Group\StructuralGroup;
use UForm\InvalidArgumentException;

/**
 * Class Inline
 * @semanticType inline
 */
class Inline extends StructuralGroup
{

    public function __construct()
    {
        parent::__construct();
        $this->addSemanticType('inline');
    }
}
