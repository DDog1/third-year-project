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
    public function dbConfig()
    {
        define('DB_HOST', 'localhost');
        define('DB_USER', 'Darren');
        define('DB_PASS', 'Play_room123');
        define('DB_NAME', 'graphicsgaminggroup');
    }
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

    public function testCanFindMatchingUsernameAndPassword()
    {
        $this->dbConfig();
        // Arrange
        $user = new Model\User();
        $user->setId(1);
        $user->setUsername("matt");
        $user->setPassword("smith");
        $user->setRole(1);

        // Act
        $result = $user->canFindMatchingUsernameAndPassword("matt", "smith");

        // Assert
        $this->assertTrue($result);
    }

    public function testCantFindMatchingUsernameAndPassword()
    {
        // Arrange
        $user = new Model\User();

        // Act
        $result = $user->canFindMatchingUsernameAndPassword("Darren", "Cosgrave");

        // Assert
        $this->assertFalse($result);
    }

    public function testCanFindMatchingUsernameAndRole()
    {
        // Arrange
        $user = new Model\User();
        $user->setUsername("matt");
        $user->setRole(1);
        $expectedResult = 1;

        // Act
        $result = $user->canFindMatchingUsernameAndRole("matt");

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testCantFindMatchingUsernameAndRole()
    {
        // Arrange
        $user = new Model\User();

        // Act
        $result = $user->canFindMatchingUsernameAndRole("Darren");

        // Assert
        $this->assertNull($result);
    }
}
