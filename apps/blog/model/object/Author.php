<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 11/5/2017
 * Time: 4:47 PM
 */

namespace apps\blog\model\object;


class Author
{
    private $id;
    private $name;
    private $email;
    private $avatar;
    private $profile;

    /**
     * Author constructor.
     *
     * @param null $id
     * @param null $name
     * @param null $email
     * @param null $avatar
     * @param null $profile
     */
    public function __construct($id = null, $name = null, $email = null,
        $avatar = null, $profile = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->avatar = $avatar;
        $this->profile = $profile;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * @return mixed
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param mixed $profile
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
    }


}