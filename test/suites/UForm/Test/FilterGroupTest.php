<?php

namespace UForm\Test;

use UForm\FilterGroup;

class FilterGroupTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var FilterGroup
     */
    protected $filterGroupStub;

    public function setup()
    {
        $this->filterGroupStub = $this->getMockForTrait('UForm\FilterGroup');
    }

    public function testSetFilter()
    {
        $filter = $this->getMockForAbstractClass('UForm\Filter');
        $this->filterGroupStub->setFilters([$filter, $filter]);
        $this->assertSame([$filter, $filter], $this->filterGroupStub->getFilters());

        $this->filterGroupStub->setFilters([]);
        $this->assertSame([], $this->filterGroupStub->getFilters());
        $this->filterGroupStub->setFilters(null);
        $this->assertSame([], $this->filterGroupStub->getFilters());
    }

    public function testAddFilter()
    {
        $filter = $this->getMockForAbstractClass('UForm\Filter');
        $this->filterGroupStub->setFilters([$filter, $filter]);
        $this->filterGroupStub->addFilter($filter);
        $this->assertSame([$filter, $filter, $filter], $this->filterGroupStub->getFilters());

        // ADD FILTER CLOSURE
        $closure = function ($v) {
            return $v;
        };
        $newFilter = $this->filterGroupStub->addFilter($closure);
        $this->assertInstanceOf('UForm\Filter\DirectClosure', $newFilter);
        $this->assertSame($closure, $newFilter->getClosure());

        $this->setExpectedException('UForm\InvalidArgumentException');
        $this->filterGroupStub->addFilter([]);
    }

    public function testAddFilters()
    {
        $filter = $this->getMockForAbstractClass('UForm\Filter');
        $this->filterGroupStub->setFilters([$filter]);
        $this->filterGroupStub->addFilters([$filter, $filter]);
        $this->assertSame([$filter, $filter, $filter], $this->filterGroupStub->getFilters());
        $this->filterGroupStub->addFilters([]);
        $this->assertSame([$filter, $filter, $filter], $this->filterGroupStub->getFilters());
    }

    public function testGetFilters()
    {
        $this->assertSame([], $this->filterGroupStub->getFilters());
    }
}
