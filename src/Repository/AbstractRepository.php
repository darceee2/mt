<?php

namespace App\Repository;

use App\Service\DocumentManager;

/**
 * App\Repository\AbstractRepository
 */
abstract class AbstractRepository
{
    /**
     * @var DocumentManager
     */
    protected $documentManager;

    /**
     * AbstractRepository constructor.
     *
     * @param DocumentManager $documentManager
     */
    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    /**
     * @return string
     */
    abstract public function getDocumentClass(): string;

    /**
     * @param $document
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function save($document)
    {
        return $this->documentManager->save($document);
    }

    /**
     * @param array $params
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function findOne(array $params = [])
    {
        return $this->documentManager->findOne($this->getDocumentClass(), $params);
    }

    /**
     * @param array $params
     * @param array $sort
     *
     * @return array
     *
     * @throws \Exception
     */
    public function find(array $params = [], array $sort = [])
    {
        return $this->documentManager->find(
            $this->getDocumentClass(),
            $params,
            $sort
        );
    }

    /**
     * @param string $id
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function remove(string $id)
    {
        return $this->documentManager->remove($this->getDocumentClass(), $id);
    }
}
