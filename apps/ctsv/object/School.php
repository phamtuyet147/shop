<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/23/2017
 * Time: 9:28 AM
 */

namespace apps\ctsv\object;


class School
{
    private $id;
    private $name;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


}