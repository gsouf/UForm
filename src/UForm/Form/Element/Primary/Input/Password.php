<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary\Input;

use UForm\Form\Element\Primary\Input;

/**
 * Class Password
 * @semanticType input:password
 * @semanticType input:textfield
 * @renderOption placeholder a placeholder text to show when it's empty
 * @renderOption leftAddon an addon to add to the left of the field
 * @renderOption rightAddon an addon to add to the right of the field
 */
class Password extends Input
{
    public function __construct($name)
    {
        parent::__construct('password', $name);
        $this->addSemanticType('input:textfield');
        $this->addSemanticType('input__textfield');
        $this->addSemanticType('input:password');
        $this->addSemanticType('input__password');
    }

    protected function overridesParamsBeforeRender($params, $value, \UForm\Form\FormContext $context = null)
    {
        $params = parent::overridesParamsBeforeRender($params, $value, $context);

        if (isset($params['value'])) {
            unset($params['value']);
        }

        return $params;
    }
}
