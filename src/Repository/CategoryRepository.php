<?php

namespace App\Repository;

use App\Document\Category;

/**
 * App\Repository\CategoryRepository
 */
class CategoryRepository extends AbstractRepository
{
    /**
     * {@inheritdoc}
     */
    public function getDocumentClass(): string
    {
        return Category::class;
    }
}
