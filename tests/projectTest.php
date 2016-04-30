<?php
/**
 * Created by PhpStorm.
 * User: Darren Cosgrave
 * Date: 30/04/2016
 * Time: 20:03
 */

namespace Itb;

class projectTest extends \PHPUnit_Framework_TestCase
{
    public function testGetId()
    {
        // arrange
        $project = new Model\Project();
        $project->setId(2);
        $expectedResult = 2;

        // act
        $result = $project->getId();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testGetTitle()
    {
        // arrange
        $project = new Model\Project();
        $project->setTitle("Project!!");
        $expectedResult = "Project!!";

        // act
        $result = $project->getTitle();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testGetDiscription()
    {
        // arrange
        $project = new Model\Project();
        $project->setDescription("Hello world!!");
        $expectedResult = "Hello world!!";

        // act
        $result = $project->getDescription();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testGetMembers()
    {
        // arrange
        $project = new Model\Project();
        $project->setMembers("Darren Cosgrave - Jame O'Conner");
        $expectedResult = "Darren Cosgrave - Jame O'Conner";

        // act
        $result = $project->getMembers();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testGetSupervisor()
    {
        // arrange
        $project = new Model\Project();
        $project->setSupervisor("Darren Cosgrave");
        $expectedResult = "Darren Cosgrave";

        // act
        $result = $project->getSupervisor();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testGetDeadline()
    {
        // arrange
        $project = new Model\Project();
        $project->setDeadline("2015-06-30");
        $expectedResult = "2015-06-30";

        // act
        $result = $project->getDeadline();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }
}
