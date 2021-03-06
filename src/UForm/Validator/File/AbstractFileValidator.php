<?php
/**
 * @license see LICENSE
 */

namespace UForm\Validator\File;

use UForm\Exception;
use UForm\FileUpload;
use UForm\Form\Element\Primary\Input\File;
use UForm\InvalidArgumentException;
use UForm\Validation\ValidationItem;
use UForm\Validator;

/**
 * Contains common logic for file validator and requires the element validated to be a file element
 *
 * File validators expect that the data were previously validated to be valid files by adding
 * the validator @see Validator\IsValid
 *
 */
abstract class AbstractFileValidator extends Validator
{

    public function validate(ValidationItem $validationItem)
    {

        $element = $validationItem->getElement();
        if (!$element instanceof File) {
            throw new \InvalidArgumentException(
                'Invalid type for file validation. File validation can only validate item of type file'
            );
        }


        if ($element->isMultiple()) {
            $value = $validationItem->getValue();
            foreach ($value as $v) {
                $this->validateItem($v, $validationItem);
                if (!$validationItem->isValid()) {
                    break;
                }
            }
        } else {
            $this->validateItem($validationItem->getValue(), $validationItem);
        }
    }

    abstract protected function validateItem($value, ValidationItem $validationItem);
}
