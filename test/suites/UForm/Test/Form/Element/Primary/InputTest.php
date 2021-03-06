<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary;

use UForm\Form\Element\Primary\Input;

class InputTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        /* @var $input Input */
        $input = $this->getMockForAbstractClass('UForm\Form\Element\Primary\Input', ['inputType', 'inputName']);

        $this->assertTrue($input->hasSemanticType('input'));
    }

    public function testRender()
    {
        /* @var $input Input */
        $input = $this->getMockForAbstractClass('UForm\Form\Element\Primary\Input', ['inputType', 'inputName']);
        $id = $input->getId();
        $expected = '<input type="inputType" name="inputName" id="' . $id . '" value="someValue"/>';
        $this->assertEquals($expected, $input->render(['inputName' => 'someValue']));

        $input->setAttribute('disabled', 'disabled');
        $expected = '<input type="inputType" name="inputName" id="' . $id . '" disabled="disabled" value="someValue"/>';
        $this->assertEquals($expected, $input->render(['inputName' => 'someValue']));

        // Render with a class in options
        $expected = '<input type="inputType" name="inputName" id="' . $id . '" disabled="disabled" class="customClass" value="someValue"/>';
        $this->assertEquals($expected, $input->render(['inputName' => 'someValue'], ['class' => 'customClass']));

        // render with a class in attr
        $input->addClass('foo');
        $expected = '<input type="inputType" name="inputName" id="' . $id . '" disabled="disabled" class="foo" value="someValue"/>';
        $this->assertEquals($expected, $input->render(['inputName' => 'someValue']));

        // render with a class in attr + in options
        $expected = '<input type="inputType" name="inputName" id="' . $id . '" disabled="disabled" class="foo customClass" value="someValue"/>';
        $this->assertEquals($expected, $input->render(['inputName' => 'someValue'], ['class' => 'customClass']));
    }
}
