<?php
/**
 * Textarea
 */
namespace UForm\Form\Element\Primary;

use UForm\Form\Element;
use UForm\Form\Element\Drawable;
use UForm\Tag;

/**
 * Textarea element
 * @semanticType textarea
 * @renderOption label the label of the element
 * @renderOption placeholder a placeholder text to show when it's empty
 * @renderOption helper text that gives further information to the user (always visible)
 * @renderOption tooltip text that gives further information to the user (visible on mouse over or click)
 */
class TextArea extends Element\Primary implements Drawable
{

    use Element\RenderHandlerTrait;

    public function __construct($name)
    {
        parent::__construct($name);
        $this->addSemanticType('textarea');
    }


    public function render($localData, array $options = [], \UForm\Form\FormContext $formContext = null)
    {

        $options = $this->processRenderOptionHandlers($localData, $options);

        $params = [
            'name' => $this->getName(true),
            'id'   => $this->getId()
        ];

        if (isset($localData[$this->getName()])) {
            $localData = $localData[$this->getName()];
        } else {
            $localData = '';
        }

        foreach ($this->getAttributes() as $attrName => $attrValue) {
            $params[$attrName] = $attrValue;
        }

        if (isset($options['attributes']) && is_array($options['attributes'])) {
            foreach ($options['attributes'] as $attrName => $attrValue) {
                $params[$attrName] = $attrValue;
            }
        }

        if (isset($options['class'])) {
            if (isset($params['class'])) {
                $params['class'] .=  ' ' . $options['class'];
            } else {
                $params['class'] = $options['class'];
            }
        }

        $render = new Tag('textarea', $params, false);

        return $render->draw([], $localData);
    }
}
