<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary;

use UForm\Form\Element\Primary\Select;

/**
 * @covers UForm\Form\Element\Primary\Select
 */
class SelectTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Select
     */
    protected $select;


    public function setUp()
    {
        $this->select = new Select('familly');
    }

    public function testConstruct()
    {
        $this->assertTrue($this->select->hasSemanticType('select'));
    }

    public function testSetOptionValues()
    {

        $this->select->setOptionValues([
            'Homer' => 'simpson',
            'Ned' => 'flanders',

            'Kids' => [
                'Bart' => 'simpson',
                'Rod' => 'flanders'
            ],

            'skinner'
        ]);

        $this->select->setId('someID');
        $this->select->setAttribute('data-foo', 'bar');

        // No selection
        $expected =
            '<select id="someID" name="familly" data-foo="bar">'

                . '<option value="simpson">Homer</option>'
                . '<option value="flanders">Ned</option>'
                . '<optgroup label="Kids">'
                    . '<option value="simpson">Bart</option>'
                    . '<option value="flanders">Rod</option>'
                . '</optgroup>'
                . '<option value="skinner">skinner</option>'

            . '</select>';
        $this->assertEquals($expected, $this->select->render([], []));

        // selection
        $expected =
            '<select id="someID" name="familly" data-foo="bar">'

            . '<option value="simpson" selected="selected">Homer</option>'
            . '<option value="flanders">Ned</option>'
            . '<optgroup label="Kids">'
                . '<option value="simpson" selected="selected">Bart</option>'
                . '<option value="flanders">Rod</option>'
            . '</optgroup>'
            . '<option value="skinner">skinner</option>'

            . '</select>';
        $this->assertEquals($expected, $this->select->render(['familly' => 'simpson'], ['familly' => 'simpson']));
    }


    public function testMultiple()
    {

        $this->select = new Select('family', null, true);

        $this->select->setOptionValues(
            [
                'Homer' => 'simpson',
                'Ned' => 'flanders',

                'Kids' => [
                    'Bart' => 'simpson',
                    'Rod' => 'flanders'
                ],

                'skinner'
            ]
        );

        $this->select->setId('someID');
        $this->select->setAttribute('data-foo', 'bar');

        // No selection
        $expected =
            '<select id="someID" name="family[]" data-foo="bar" multiple>'

            . '<option value="simpson">Homer</option>'
            . '<option value="flanders">Ned</option>'
            . '<optgroup label="Kids">'
            . '<option value="simpson">Bart</option>'
            . '<option value="flanders">Rod</option>'
            . '</optgroup>'
            . '<option value="skinner">skinner</option>'

            . '</select>';
        $this->assertEquals($expected, $this->select->render([], []));



        // WITH VALUES
        $expected =
            '<select id="someID" name="family[]" data-foo="bar" multiple>'

            . '<option value="simpson" selected="selected">Homer</option>'
            . '<option value="flanders">Ned</option>'
            . '<optgroup label="Kids">'
            . '<option value="simpson" selected="selected">Bart</option>'
            . '<option value="flanders">Rod</option>'
            . '</optgroup>'
            . '<option value="skinner" selected="selected">skinner</option>'

            . '</select>';
        $this->assertEquals($expected, $this->select->render(['family' => ['simpson', 'skinner']], []));
    }
}
