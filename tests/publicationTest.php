<?php
/**
 * Created by PhpStorm.
 * User: Darren Cosgrave
 * Date: 14/04/2016
 * Time: 08:58
 */

namespace Itb;

class publicationTest extends \PHPUnit_Framework_TestCase
{
    public function testGetId()
    {
        // Arrange
        $publication = new Model\Publication();
        $publication->setId(1);
        $expectedResult = 1;

        // Act
        $result = $publication->getId();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testGetTitle()
    {
        // Arrange
        $publication = new Model\Publication();
        $publication->setTitle("Title");
        $expectedResult = "Title";

        // Act
        $result = $publication->getTitle();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testGetAuthorId()
    {
        // Arrange
        $publication = new Model\Publication();
        $publication->setAuthorId(1);
        $expectedResult = 1;

        // Act
        $result = $publication->getAuthorId();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testGetUrl()
    {
        // Arrange
        $publication = new Model\Publication();
        $publication->setUrl("downloads/darren.pdf");
        $expectedResult = "downloads/darren.pdf";

        // Act
        $result = $publication->getUrl();

        // Assert
        $this->assertEquals($expectedResult, $result);
    }
}
