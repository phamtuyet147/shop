<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/15/2018
 * Time: 10:26 AM
 */

namespace apps\shop\model\object;


class Customer
{
    private $id;
    private $name;
    private $phone;
    private $email;
    private $address;
    private $gender;

    /**
     * Customer constructor.
     *
     * @param null $id
     * @param null $name
     * @param null $phone
     * @param null $email
     * @param null $address
     * @param null $gender
     */
    public function __construct($id = null, $phone = null,
        $email = null, $name = null, $address = null, $gender = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
        $this->gender = $gender;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param null $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param null $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return null
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param null $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return null
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param null $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }
}