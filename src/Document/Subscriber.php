<?php

namespace App\Document;

use App\Annotation\Document;
use JMS\Serializer\Annotation as JMS;

/**
 * App\Document\Subscriber
 *
 * @Document
 */
class Subscriber extends AbstractDocument
{
    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $name;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $email;

    /**
     * @JMS\Type("array")
     *
     * @var array
     */
    protected $categories;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * Subscriber constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Getter of Name
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Setter of Name
     *
     * @param string $name
     *
     * @return static
     */
    public function setName(?string $name): Subscriber
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Getter of Email
     *
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Setter of Email
     *
     * @param string $email
     *
     * @return static
     */
    public function setEmail(?string $email): Subscriber
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Getter of Categories
     *
     * @return array
     */
    public function getCategories(): ?array
    {
        return $this->categories;
    }

    /**
     * Setter of Categories
     *
     * @param array $categories
     *
     * @return static
     */
    public function setCategories(?array $categories): Subscriber
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Getter of CreatedAt
     *
     * @return \DateTime
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * Setter of CreatedAt
     *
     * @param \DateTime $createdAt
     *
     * @return static
     */
    public function setCreatedAt(?\DateTime $createdAt): Subscriber
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
