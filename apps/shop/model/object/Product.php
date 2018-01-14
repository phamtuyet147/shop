<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/14/2018
 * Time: 10:10 PM
 */

namespace apps\shop\model\object;


class Product
{
    private $id;
    private $categoryId;
    private $title;
    private $shortTag;
    private $price;
    private $shortDesc;
    private $desc;
    private $thumbnail;
    private $createdDate;
    private $modifiedDate;

    /**
     * Product constructor.
     *
     * @param null $id
     * @param null $categoryId
     * @param null $title
     * @param null $shortTag
     * @param null $price
     * @param null $shortDesc
     * @param null $desc
     * @param null $thumbnail
     * @param null $createdDate
     * @param null $modifiedDate
     */
    public function __construct($id = null, $categoryId = null, $title = null,
        $shortTag = null, $price = null, $shortDesc = null, $desc = null,
        $thumbnail = null, $createdDate = null, $modifiedDate = null
    ) {
        $this->id = $id;
        $this->categoryId = $categoryId;
        $this->title = $title;
        $this->shortTag = $shortTag;
        $this->price = $price;
        $this->shortDesc = $shortDesc;
        $this->desc = $desc;
        $this->thumbnail = $thumbnail;
        $this->createdDate = $createdDate;
        $this->modifiedDate = $modifiedDate;
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
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param mixed $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
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
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getShortDesc()
    {
        return $this->shortDesc;
    }

    /**
     * @param mixed $shortDesc
     */
    public function setShortDesc($shortDesc)
    {
        $this->shortDesc = $shortDesc;
    }

    /**
     * @return mixed
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @param mixed $desc
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;
    }

    /**
     * @return mixed
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param mixed $thumbnail
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return mixed
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * @param mixed $createdDate
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;
    }

    /**
     * @return mixed
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * @param mixed $modifiedDate
     */
    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;
    }
}