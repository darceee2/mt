<?php

namespace App\Document;

use App\DocumentInterface;
use JMS\Serializer\Annotation as JMS;

/**
 * App\Document\AbstractDocument
 */
abstract class AbstractDocument implements DocumentInterface
{
    /**
     * @JMS\Type("string")
     *
     * @var string
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
    public function setId(?string $id): AbstractDocument
    {
        $this->id = $id;

        return $this;
    }
}
