<?php
/**
 * User: Darren Cosgrave
 */

namespace Itb\model;

use Mattsmithdev\PdoCrud\DatabaseTable;

/**
 * Class Action
 * @package Itb\model
 */
class Action extends DatabaseTable
{
    /**
     * the id of the list
     * @var int
     */
    private $id;
    /**
     * the description of the list
     * @var string
     */
    private $description;
    /**
     * the implementor id for the list
     * @var int
     */
    private $implementorid;
    /**
     * the deadline for the list
     * @var mixed
     */
    private $deadline;
    /**
     * the status of the list
     * @var int
     */
    private $status;

    /**
     * gets the id of the list
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * sets the id of the list
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * gets the description of the list
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * sets the description of the list
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * gets the implementor id of the list
     * @return mixed
     */
    public function getImplementorid()
    {
        return $this->implementorid;
    }

    /**
     * sets the implementor id of the list
     * @param mixed $implementorid
     */
    public function setImplementorid($implementorid)
    {
        $this->implementorid = $implementorid;
    }

    /**
     * gets the deadline of the list
     * @return mixed
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * sets the deadline of the list
     * @param mixed $deadline
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    }

    /**
     * gets the status of the list
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * sets the status of the list
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}
