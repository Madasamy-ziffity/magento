<?php

namespace Training\UnitTest\Test\Unit\Model;

class Calculator extends  \PHPUnit\Framework\TestCase {

    protected $_objectManager;
    protected $_desiredResult;
    protected $_actulResult;
    protected $_calculator;
    /**
     * Unset the variables and objects after use
     *
     * @return void
     */
    public function tearDown(): void {
        
    }

    /**
     * Used to set the values to variables or objects.
     *
     * @return void
     */
    public function setUp(): void {
        $this->_objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->_calculator = $this->_objectManager->getObject("Training\UnitTest\Model\Calculator");
        //can do stuff
    }
    /**
     * This function will perform the addition of two numbers
     *
     * @param float $a
     * @param float $b
     * @return float
     */
    public function testAddition() { 
         $this->_actulResult = $this->_calculator->addition(7.0,3.0);
         $this->_desiredResult = 10.0;
         $this->assertEquals($this->_desiredResult, $this->_actulResult);
    }
}