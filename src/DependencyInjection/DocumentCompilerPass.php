<?php

namespace App\DependencyInjection;

use App\Service\DocumentAnnotationLoader;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * App\DependencyInjection\DocumentCompilerPass
 */
class DocumentCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $annotationsLoader = $container->get(DocumentAnnotationLoader::class);
        $annotationsData = $annotationsLoader->loadDocumentsData();
        $container->setParameter('documents_annotations', $annotationsData);
    }
}
