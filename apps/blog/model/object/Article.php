<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 11/5/2017
 * Time: 4:47 PM
 */

namespace apps\blog\model\object;


class Article
{
    private $id;
    private $title;
    private $content;
    private $author;
    private $createDate;
    private $modifiedDate;
    private $shortURL;
    private $status;

    /**
     * Article constructor.
     *
     * @param null $id
     * @param null $title
     * @param null $content
     * @param null $author
     * @param null $createDate
     * @param null $modifiedDate
     * @param null $shortURL
     * @param int  $status
     */
    public function __construct($id = null, $title = null, $content = null,
        $author = null, $createDate = null, $modifiedDate = null,
        $shortURL = null, $status = 0
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        if (empty($this->author)) {
            $this->author = new Author();
        } else {
            $this->author = $author;
        }
        $this->createDate = $createDate;
        $this->modifiedDate = $modifiedDate;
        $this->shortURL = $shortURL;
        $this->status = $status;
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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @param mixed $createDate
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
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

    /**
     * @return mixed
     */
    public function getShortURL()
    {
        return $this->shortURL;
    }

    /**
     * @param mixed $shortURL
     */
    public function setShortURL($shortURL)
    {
        $this->shortURL = $shortURL;
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