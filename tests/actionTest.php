<?php
/**
 * Created by PhpStorm.
 * action: Darren Cosgrave
 * Date: 14/04/2016
 * Time: 08:40
 */

namespace Itb;

class actionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetId()
    {
        // Arrange
        $action = new Model\Action();
        $action->setId(1);
        $expectedResult = 1;

        // Act
        $result = $action->getId();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }
    
    public function testGetDescription()
    {
        // Arrange
        $action = new Model\Action();
        $action->setDescription("Description");
        $expectedResult = "Description";

        // Act
        $result = $action->getDescription();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testGetImplementorId()
    {
        // Arrange
        $action = new Model\Action();
        $action->setImplementorid("ImplementorId");
        $expectedResult = "ImplementorId";

        // Act
        $result = $action->getImplementorid();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testGetDeadLine()
    {
        // Arrange
        $action = new Model\Action();
        $action->setDeadline("2016-04-01");
        $expectedResult = "2016-04-01";

        // Act
        $result = $action->getDeadline();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testGetStatus()
    {
        // Arrange
        $action = new Model\Action();
        $action->setStatus(1);
        $expectedResult = 1;

        // Act
        $result = $action->getStatus();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }
}
