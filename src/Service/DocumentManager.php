<?php

namespace App\Service;

use App\DocumentInterface;
use JMS\Serializer\SerializerInterface;

/**
 * App\Service\DocumentManager
 */
class DocumentManager
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var Storage
     */
    protected $storage;

    /**
     * @var array
     */
    protected $documents = [];

    /**
     * DocumentManager constructor.
     *
     * @param SerializerInterface $serializer
     * @param Storage $storage
     * @param array $documents
     */
    public function __construct(
        SerializerInterface $serializer,
        Storage $storage,
        array $documents = []
    ) {
        $this->serializer = $serializer;
        $this->storage = $storage;
        $this->documents = $documents;
    }

    /**
     * @param DocumentInterface $document
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function save(DocumentInterface $document)
    {
        return $this->storage->save(
            $this->getDocumentType(get_class($document)),
            $document
        );
    }

    /**
     * @param string $class
     * @param array  $params
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function findOne(string $class, array $params = [])
    {
        $result = $this->storage->findOne(
            $this->getDocumentType($class),
            $params
        );

        if ($result) {
            $result = $this->serializer->deserialize(json_encode($result), $class, 'json');
        }

        return $result;
    }

    /**
     * @param string $class
     * @param array  $params
     * @param array  $sort
     *
     * @return array
     *
     * @throws \Exception
     */
    public function find(string $class, array $params = [], array $sort = [])
    {
        $results = [];
        $queryResults = $this->storage->find(
            $this->getDocumentType($class),
            $params,
            $sort
        );

        foreach ($queryResults as $queryResult) {
            $result = $this->serializer->deserialize(json_encode($queryResult), $class, 'json');
            $results[$result->getId()] = $result;
        }

        return $results;
    }

    /**
     * @param string $class
     * @param string $id
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function remove(string $class, string $id)
    {
        return $this->storage->remove($this->getDocumentType($class), $id);
    }

    /**
     * @param string $class
     *
     * @return mixed
     *
     * @throws \Exception
     */
    protected function getDocumentType(string $class)
    {
        if (empty($this->documents[$class])) {
            throw new \Exception(sprintf('Class %s not mapped', $class));
        }

        return $this->documents[$class];
    }
}
