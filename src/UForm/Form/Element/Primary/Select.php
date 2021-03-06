<?php

/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary;

use UForm\Form\Element;
use UForm\Form\Element\Primary\Select\OptGroup;
use UForm\Tag;

/**
 * Class Select
 * @semanticType select
 * @renderOption label the label of the element
 * @renderOption placeholder a placeholder text to show when it's empty
 * @renderOption helper text that gives further information to the user (always visible)
 * @renderOption tooltip text that gives further information to the user (visible on mouse over or click)
 * @renderOption leftAddon an addon to add to the left of the field
 * @renderOption rightAddon an addon to add to the right of the field
 */
class Select extends Element\Primary implements Element\Drawable
{
    /**
     * @var OptGroup
     */
    protected $rootGroup;

    protected $isMultiple;

    use Element\RenderHandlerTrait;

    /**
     * \UForm\Form\Element constructor
     *
     * @param string $name
     * @param array|null $values
     * @param array|null $attributes
     */
    public function __construct($name, array $values = null, $multiple = false)
    {
        parent::__construct($name);

        $this->rootGroup = new OptGroup('');
        $this->rootGroup->setSelect($this);

        if (null !== $values) {
            $this->setOptionValues($values);
        }

        $this->isMultiple = $multiple == true;

        $this->addSemanticType('select');
    }


    /**
     * Set the choice's options
     *
     * @param array|object $options
     */
    public function setOptionValues(array $options)
    {
        $this->rootGroup->addOptions($options);
    }

    /**
     * @return bool
     */
    public function isMultiple()
    {
        return $this->isMultiple;
    }

    /**
     * Returns the choices' options
     *
     * @param $localData
     * @param array $options
     * @param \UForm\Form\FormContext|\UForm\Render\RenderContext $formContext
     * @return array|null|object
     */
//    public function getOptionValues()
//    {
//        return $this->optionsValues;
//    }




    public function render($localData, array $options = [], \UForm\Form\FormContext $formContext = null)
    {

        $options = $this->processRenderOptionHandlers($localData, $options);

        $params = [
            'id' => $this->getId(),
            'name' => $this->getName(true)
        ];

        foreach ($this->getAttributes() as $attrName => $attrValue) {
            $params[$attrName] = $attrValue;
        }

        if (isset($options['attributes']) && is_array($options['attributes'])) {
            foreach ($options['attributes'] as $attrName => $attrValue) {
                $params[$attrName] = $attrValue;
            }
        }

        if (isset($options['class'])) {
            $params['class'] = $options['class'];
        }


        if ($this->isMultiple) {
            $params['multiple'] = true;
            $params['name'] .= '[]';
        } elseif (isset($params['multiple'])) {
            unset($params['multiple']);
        }

        if (isset($localData[$this->getName()])) {
            $localData = $localData[$this->getName()];
        } else {
            $localData = null;
        }

        $render = new Tag('select', $params, false);

        $selectOptions = '';

        foreach ($this->rootGroup->getOptions() as $v) {
            $selectOptions .= $v->render($localData);
        }

        return $render->draw([], $selectOptions);
    }
}
