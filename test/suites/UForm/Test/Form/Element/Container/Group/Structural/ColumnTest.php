<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Container\Group\Structural;

use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Container\Group\Structural\Column;
use UForm\Form\Element\Container\Group\Structural\ColumnGroup;

class ColumnTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $column = new Column(5);

        $this->assertSame(5, $column->getWidth());
        $this->assertTrue($column->hasSemanticType('column'));

        $this->setExpectedException('UForm\Exception');
        new Column(-2);
    }

    public function testSetParent()
    {
        $columnGroup = new ColumnGroup();
        $column = new Column(5);
        $column->setParent($columnGroup);

        $this->assertSame($columnGroup, $column->getParent());

        $this->setExpectedException('UForm\Exception');
        $column->setParent(new Group());
    }

    public function testGetAdaptiveWidth()
    {

        // No parent
        $column = new Column(5);
        $this->assertEquals(10, $column->getAdaptiveWidth(10));


        // With parent
        $columnGroup = $this->getMockBuilder('UForm\Form\Element\Container\Group\Structural\ColumnGroup')->getMock();
        $column->setParent($columnGroup);
        $columnGroup->method('getWidthInPercent')->willReturn(100);
        $this->assertEquals(10, $column->getAdaptiveWidth(10));
        $this->assertEquals(12, $column->getAdaptiveWidth(12));

        // mock other children in parent
        $columnGroup = $this->getMockBuilder('UForm\Form\Element\Container\Group\Structural\ColumnGroup')->getMock();
        $columnGroup->method('getWidthInPercent')->willReturn(50);
        $column->setParent($columnGroup);
        $this->assertEquals(6, $column->getAdaptiveWidth(12));

        $columnGroup = $this->getMockBuilder('UForm\Form\Element\Container\Group\Structural\ColumnGroup')->getMock();
        $columnGroup->method('getWidthInPercent')->willReturn(25);
        $column->setParent($columnGroup);
        $this->assertEquals(3, $column->getAdaptiveWidth(12));


        $columnGroup = new ColumnGroup();
        $c = new Column(25, 100);
        $columnGroup->addElement($c);
        $columnGroup->addElement(new Column(75, 100));

        $this->assertEquals(25, $c->getAdaptiveWidth(100));
        $this->assertEquals(3, $c->getAdaptiveWidth(12));

        $columnGroup->addElement(new Column(50, 100));
        $this->assertEquals(16.67, round($c->getAdaptiveWidth(100), 2));
        $this->assertEquals(2, round($c->getAdaptiveWidth(12), 2));


        $this->setExpectedException('UForm\InvalidArgumentException');
        $column->getAdaptiveWidth('fake');
    }

    public function testGetWidthOnScale()
    {
        $column = new Column(5);
        $this->assertEquals(5, $column->getWidthOnScale(100));
        $this->assertEquals(2.5, $column->getWidthOnScale(50));

        $column = new Column(5, 12);
        $this->assertEquals(41.67, round($column->getWidthOnScale(100), 2));
        $this->assertEquals(5, $column->getWidthOnScale(12));

        $this->setExpectedException('UForm\InvalidArgumentException');
        $column->getAdaptiveWidth('fake');
    }
}
