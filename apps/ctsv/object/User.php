<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/19/2017
 * Time: 9:32 PM
 */

namespace apps\ctsv\object;


class User
{
    private $id;
    private $username;
    private $schools;

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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return School[]
     */
    public function getSchools()
    {
        return $this->schools;
    }

    /**
     * @param School[] $school
     */
    public function setSchools($school)
    {
        $this->schools = $school;
    }
}