<?php

namespace App\Document;

use App\Annotation\Document;
use JMS\Serializer\Annotation as JMS;

/**
 * App\Document\Category
 *
 * @Document
 */
class Category extends AbstractDocument
{
    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    protected $name;

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
    public function setName(?string $name): Category
    {
        $this->name = $name;

        return $this;
    }
}
