<?php

namespace App\Document;

use App\Annotation\Document;
use App\DocumentInterface;
use FOS\UserBundle\Model\User as BaseUser;
use JMS\Serializer\Annotation as JMS;

/**
 * App\Document\User
 *
 * @JMS\ExclusionPolicy("none")
 * @Document
 */
class User extends BaseUser implements DocumentInterface
{
    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $username;

    /**
     * @JMS\Type("string")
     */
    protected $usernameCanonical;

    /**
     * @JMS\Type("string")
     */
    protected $email;

    /**
     * @JMS\Type("string")
     */
    protected $emailCanonical;

    /**
     * @JMS\Type("string")
     */
    protected $enabled;

    /**
     * @JMS\Type("string")
     */
    protected $salt;

    /**
     * @JMS\Type("string")
     */
    protected $password;

    /**
     * @JMS\Type("string")
     */
    protected $plainPassword;

    /**
     * @JMS\Type("array")
     */
    protected $groups;

    /**
     * @JMS\Type("array")
     */
    protected $roles;

    /**
     * @var string
     *
     * @JMS\Type("string")
     */
    protected $id;

    /**
     * Getter of Id
     *
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Setter of Id
     *
     * @param string $id
     *
     * @return static
     */
    public function setId(?string $id): User
    {
        $this->id = $id;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastLogin(\DateTime $time = null)
    {
        $this->lastLogin = $time ? $time->format('Y-m-d H:i:s') : null;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastLogin()
    {
        return $this->lastLogin ? new \DateTime($this->lastLogin) : $this->lastLogin;
    }
}
