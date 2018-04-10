<?php

namespace Entity;


/**
 * Class User
 * @package Entity
 */
class User
{
    /**
     * @var
     */
    private $username;
    /**
     * @var
     */
    private $hashedPw;
    /**
     * @var
     */
    private $email;
    /**
     * @var
     */
    private $roles;

    /**
     * User constructor.
     * @param $datas
     */
    public function __construct($datas)
    {
        $this->hydrate($datas);
    }

    /**
     * @param $datas
     */
    public function hydrate($datas)
    {
        $this->setUsername($datas['username']);
        $this->setHashedPw($datas['password']);
        $this->setEmail($datas['email']);
        $this->setRoles($datas['roles']);
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getHashedPw()
    {
        return $this->hashedPw;
    }

    /**
     * @param $hashedPw
     */
    public function setHashedPw($hashedPw)
    {
        $this->hashedPw = $hashedPw;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }
}