<?php

namespace App\Repository;

use App\Document\Subscriber;

/**
 * App\Repository\SubscriberRepository
 */
class SubscriberRepository extends AbstractRepository
{
    /**
     * {@inheritdoc}
     */
    public function getDocumentClass(): string
    {
        return Subscriber::class;
    }
}
