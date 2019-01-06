<?php

namespace App\Service;

use App\DocumentInterface;
use Filebase\Database;
use Filebase\Document;
use Filebase\Filesystem\FilesystemException;
use ReflectionClass;

/**
 * App\Service\Storage
 */
class Storage
{
    /**
     * @var string
     */
    protected $storageDir;

    /**
     * Storage constructor.
     * @param string $storageDir
     */
    public function __construct(string $storageDir)
    {
        $this->storageDir = $storageDir;
    }

    /**
     * @param string $documentType
     * @param array  $params
     *
     * @return mixed
     *
     * @throws FilesystemException
     */
    public function findOne(string $documentType, array $params)
    {
        $result = $this->find($documentType, $params);

        if (count($result) > $result) {
            throw new \Exception('Too many results');
        }

        return $result ? $result[0] : $result;
    }

    /**
     * @param string $documentType
     * @param array  $params
     * @param array  $sort
     *
     * @return mixed
     *
     * @throws FilesystemException
     */
    public function find(string $documentType, array $params = [], array $sort = [])
    {
        $dataBase = $this->prepareDatabase($documentType);
        $query = $dataBase->query();

        foreach ($params as $field => $value) {
            $query->andWhere($field, '==', $value);
        }

        foreach ($sort as $sortParam) {
            $query->orderBy($sortParam, 'ASC');
        }

        $results = $query->results();

        return $results;
    }

    /**
     * @param string            $documentType
     * @param DocumentInterface $document
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function save(string $documentType, DocumentInterface $document)
    {
        $dataBase = $this->prepareDatabase($documentType);
        $storedDocument = $this->prepareDocument($dataBase, $document);
        $this->processDocument($document, $storedDocument);

        return $storedDocument->save();
    }

    /**
     * @param string $documentType
     * @param string $id
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function remove(string $documentType, string $id)
    {
        $dataBase = $this->prepareDatabase($documentType);

        return $dataBase->delete($dataBase->get($id));
    }

    /**
     * @param string $class
     *
     * @return Database
     *
     * @throws \Filebase\Filesystem\FilesystemException
     */
    protected function prepareDatabase(string $class): Database
    {
        $dir = $this->storageDir . '/database';

        $dataBase = new Database([
            'dir'            => $dir . '/main/' . $class,
            'backupLocation' => $dir . '/backup/' . $class,
            'format'         => \Filebase\Format\Json::class,
            'cache'          => false,
            'pretty'         => true,
            'read_only'      => false,
        ]);

        return $dataBase;
    }

    /**
     * @param Database          $database
     * @param DocumentInterface $document
     *
     * @return Document
     */
    protected function prepareDocument(Database $database, DocumentInterface $document): Document
    {
        if (!$document->getId()) {
            $document->setId(uniqid());
        }

        $storedDocument = $database->get($document->getId());

        return $storedDocument;
    }

    /**
     * @param DocumentInterface $document
     * @param Document          $storedDocument
     *
     * @return Document
     *
     * @throws \ReflectionException
     */
    protected function processDocument(DocumentInterface $document, Document $storedDocument): Document
    {
        $reflectionClass = new ReflectionClass($document);
        $properties = $reflectionClass->getProperties();

        foreach ($properties as $property) {
            $property->setAccessible(true);

            if ($property->getName() == 'id' && empty($property->getValue($document))) {
                continue;
            }

            $storedDocument->{$property->getName()} = $property->getValue($document);
        }

        return $storedDocument;
    }
}
