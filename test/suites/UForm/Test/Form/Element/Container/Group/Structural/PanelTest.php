<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Container\Group\Structural;

use UForm\Form\Element\Container\Group\Structural\Panel;

class PanelTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $group = new Panel('myTitle');

        $this->assertEquals('myTitle', $group->getOption('title'));
        $this->assertTrue($group->hasSemanticType('panel'));
    }
}
