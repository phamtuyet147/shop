<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 12/10/2017
 * Time: 10:39 PM
 */

namespace apps\blog\model\object;


class Label
{
    private $tag;
    private $title;

    /**
     * Label constructor.
     *
     * @param null $tag
     * @param null $title
     */
    public function __construct($tag = null, $title = null)
    {
        $this->tag = $tag;
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param mixed $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
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
}