<?php

namespace Org\Gucken\Rad\Service;

use TYPO3\Flow\Annotations as Flow;


class ReflectionService {
    
    
    /**
     * @Flow\Inject
     * @var \TYPO3\Flow\Reflection\ReflectionService
     */
    protected $fieldReflectionService;


    /**
     * @Flow\Inject
     * @var \TYPO3\Flow\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * 
     * @param Object|string The class to lookup the repository for
     * @return \TYPO3\Flow\Persistence\Repository
     */
    public function getRepositoryFor($object) {
        $propertyClass = is_object($object) ? \get_class($object) : $object;
        $propertyClassSchema = $this->fieldReflectionService->getClassSchema($propertyClass);
        if (!$propertyClassSchema) {
            return null;
        }
        $repositoryClassName = $propertyClassSchema->getRepositoryClassName();
        if (!$repositoryClassName) {
            return null;
        }
        return $this->objectManager->get($repositoryClassName);
    }
    

}

?>
