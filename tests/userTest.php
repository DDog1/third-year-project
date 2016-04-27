<?php
/**
 * Created by PhpStorm.
 * User: Darren Cosgrave
 * Date: 13/04/2016
 * Time: 17:30
 */

namespace Itb;

class userTest extends \PHPUnit_Framework_TestCase
{
    public function testGetUserId()
    {
        // Arrange
        $user = new Model\User();
        $user->setId(1);
        $expectedResult = 1;

        // Act
        $result = $user->getId();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testGetUsername()
    {
        // Arrange
        $user = new Model\User();
        $user->setUsername("Darren");
        $expectedResult = "Darren";

        // Act
        $result = $user->getUsername();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testGetPassword()
    {
        // Arrange
        $user = new Model\User();
        $user->setPassword("Darren123");
        $expectedResult = true;

        // Act
        $password = $user->getPassword();
        $result = password_verify("Darren123", $password);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testGetRole()
    {
        // Arrange
        $user = new Model\User();
        $user->setRole(1);
        $expectedResult = "1";

        // Act
        $result = $user->getRole();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }
/*
    public function testCanFindMatchingUsernameAndPassword()
    {
        // Arrange
        $user = new Model\User();
        $user->setUsername("Darren");
        $user->setPassword("Darren123");
        $expectedResult = 1;

        // Act
        $result = $user->canFindMatchingUsernameAndPassword("Darren", "Darren123");

        // Assert
        $this->assertTrue($expectedResult, $result);
    }

    public function testCanFindMatchingUsernameAndRole()
    {
        // Arrange
        $user = new Model\User();
        $user->setUsername("Darren");
        $user->setRole(1);
        $expectedResult = 1;

        // Act
        $result = $user->canFindMatchingUsernameAndRole("Darren");

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testGetOneByUsername()
    {
        // Arrange
        $user = new Model\User();
        $user->setUsername("Darren");
        $expectedResult = 1;

        // Act
        $result = $user->getOneByUsername("Darren");

        // Assert
        $this->assertEquals($expectedResult, $result);
    }*/
}
