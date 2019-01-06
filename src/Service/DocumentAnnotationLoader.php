<?php

namespace App\Service;

use App\Annotation\Document;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Finder\Finder;

/**
 * App\Service\DocumentAnnotationLoader
 */
class DocumentAnnotationLoader
{
    protected CONST DOCUMENTS_PATH = 'Document';
    protected CONST NAME_SPACE = 'App\\Document';

    /**
     * @var AnnotationReader
     */
    protected $annotationReader;

    /**
     * @var string
     */
    protected $projectDir;

    /**
     * DocumentAnnotationLoader constructor.
     *
     * @param AnnotationReader $annotationReader
     * @param string $projectDir
     */
    public function __construct(
        AnnotationReader $annotationReader,
        string $projectDir
    ) {
        $this->annotationReader = $annotationReader;
        $this->projectDir = $projectDir;
    }

    /**
     * @return array
     *
     * @throws \ReflectionException
     */
    public function loadDocumentsData(): array
    {
        $data = [];

        $finder = $this->getFinder();
        $finder->files()->in($this->projectDir . '/' . self::DOCUMENTS_PATH);

        foreach ($finder as $file) {
            $baseName = $file->getBasename('.php');
            $class = self::NAME_SPACE . '\\' . $baseName;

            $reflectionClass = new \ReflectionClass($class);
            $classAnnotations = $this->annotationReader->getClassAnnotations($reflectionClass);

            foreach ($classAnnotations as $classAnnotation) {
                if (!$classAnnotation instanceof Document) {
                    continue;
                }

                $data[$class] = strtolower($baseName);
            }
        }

        return $data;
    }

    /**
     * @return Finder
     */
    protected function getFinder(): Finder
    {
        $finder = new Finder();

        return $finder;
    }
}
