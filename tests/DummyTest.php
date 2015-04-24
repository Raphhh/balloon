<?php
class DummyTest extends \PHPUnit_Framework_TestCase
{

    public function testDummy()
    {
        $dummy = new Dummy();
        $this->assertTrue($dummy->getTrue());
    }
}
