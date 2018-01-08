<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/7/2018
 * Time: 8:00 PM
 */

namespace apps\shop\model\object;


class Category
{
    private $id;
    private $title;
    private $shortTag;
    private $parentId;

    /**
     * Category constructor.
     *
     * @param null $id
     * @param null $title
     * @param null $shortTag
     * @param null $parentId
     */
    public function __construct($id = null, $title = null, $shortTag = null,
        $parentId = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->shortTag = $shortTag;
        $this->parentId = $parentId;
    }

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getShortTag()
    {
        return $this->shortTag;
    }

    /**
     * @param mixed $shortTag
     */
    public function setShortTag($shortTag)
    {
        $this->shortTag = $shortTag;
    }

    /**
     * @return mixed
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param mixed $parentId
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }
}