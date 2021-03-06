<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Filter;

use PHPUnit\Framework\TestCase;
use UForm\Filter\ArrayValue;

class ArrayValueTest extends TestCase
{

    public function testFilter()
    {
        $filter = new ArrayValue();

        $this->assertEquals([1], $filter->filter(1));
        $this->assertEquals([], $filter->filter(null));
        $this->assertEquals([1], $filter->filter([1]));
        $this->assertEquals([1, 2], $filter->filter([1, 2]));

        $filter = new ArrayValue(true);
        $this->assertEquals([1], $filter->filter(1));
        $this->assertEquals([null], $filter->filter(null));
    }
}
