<?php
/**
 * Created by PhpStorm.
 * User: Darren Cosgrave
 * Date: 30/03/2016
 * Time: 16:39
 */

namespace Itb\model;

use Mattsmithdev\PdoCrud\DatabaseTable;

class Action extends DatabaseTable
{
    private $id;
    private $description;
    private $implementorid;
    private $deadline;
    private $status;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getImplementorid()
    {
        return $this->implementorid;
    }

    /**
     * @param mixed $implementorid
     */
    public function setImplementorid($implementorid)
    {
        $this->implementorid = $implementorid;
    }

    /**
     * @return mixed
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * @param mixed $deadline
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}
