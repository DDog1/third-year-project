<?php
/**
 * User: Darren Cosgrave
 */

namespace Itb\model;

use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;

/**
 * Class Project
 * @package Itb\model
 */
class Project extends DatabaseTable
{
    /**
     * the id of the project
     * @var int
     */
    private $id;
    /**
     * the title of the project
     * @var string
     */
    private $title;
    /**
     * the description of the project
     * @var string
     */
    private $description;
    /**
     * the members involved in the project
     * @var string
     */
    private $members;
    /**
     * the supervisor looking after the project
     * @var string
     */
    private $supervisor;
    /**
     * the deadline for the project
     * @var mixed
     */
    private $deadline;

    /**
     * gets the id of the project
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * sets the id of the project
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * gets the title of the project
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * sets the title of the project
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * gets the description of the project
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * sets the description of the project
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * gets the members in the project
     * @return mixed
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * sets the members in the project
     * @param mixed $members
     */
    public function setMembers($members)
    {
        $this->members = $members;
    }

    /**
     * gets the supervisor in the project
     * @return mixed
     */
    public function getSupervisor()
    {
        return $this->supervisor;
    }

    /**
     * sets the supervisor in the project
     * @param mixed $supervisor
     */
    public function setSupervisor($supervisor)
    {
        $this->supervisor = $supervisor;
    }

    /**
     * gets the deadline of the project
     * @return mixed
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * sets the deadline of the project
     * @param mixed $deadline
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    }
}
