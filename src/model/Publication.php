<?php
/**
 * Created by PhpStorm.
 * User: Darren Cosgrave
 * Date: 31/03/2016
 * Time: 02:12
 */

namespace Itb\model;

use Mattsmithdev\PdoCrud\DatabaseTable;

/**
 * Class Publication
 * @package Itb\model
 */
class Publication extends DatabaseTable
{
    /**
     * the id of the publication
     * @var int
     */
    private $id;
    /**
     * the title of the publication
     * @var string
     */
    private $title;
    /**
     * the author id of the publication
     * @var int
     */
    private $authorId;
    /**
     * the url for the publication
     * @var string
     */
    private $url;

    /**
     * gets the id of publication
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * sets the id of publication
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * get the title of publication
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * set the title of publication
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * get the author id of the publication
     * @return mixed
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * set the author id of the publication
     * @param mixed $authorId
     */
    public function setAuthorId($authorId)
    {
        $this->authorId = $authorId;
    }

    /**
     * get the url link to publication
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * set the url link to publication
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}
