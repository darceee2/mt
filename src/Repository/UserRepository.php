<?php

namespace App\Repository;

use App\Document\User;

/**
 * App\Repository\UserRepository
 */
class UserRepository extends AbstractRepository
{
    /**
     * {@inheritdoc}
     */
    public function getDocumentClass(): string
    {
        return User::class;
    }
}
