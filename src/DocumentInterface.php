<?php

namespace App;

/**
 * App\DocumentInterface
 */
interface DocumentInterface
{
    /**
     * @param string $id
     *
     * @return DocumentInterface
     */
    public function setId(string $id);

    /**
     * @return string
     */
    public function getId(): ?string;
}
