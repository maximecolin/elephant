<?php

namespace App\Domain\Model;

class Collaborator
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var bool
     */
    private $admin = false;

    /**
     * Collaborator constructor.
     *
     * @param string $email
     * @param string $password
     * @param string $firstname
     * @param string $lastname
     */
    public function __construct(string $email, string $password, string $firstname, string $lastname)
    {
        $this->email     = $email;
        $this->password  = $password;
        $this->firstname = $firstname;
        $this->lastname  = $lastname;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Get admin
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->admin;
    }
}
