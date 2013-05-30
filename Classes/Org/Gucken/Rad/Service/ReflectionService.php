<?php

namespace Org\Gucken\Rad\Service;

use TYPO3\FLOW3\Annotations as FLOW3;


class ReflectionService {
    
    
    /**
     * @FLOW3\Inject
     * @var \TYPO3\FLOW3\Reflection\ReflectionService
     */
    protected $fieldReflectionService;


    /**
     * @FLOW3\Inject
     * @var \TYPO3\FLOW3\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * 
     * @param Object|string The class to lookup the repository for
     * @return \TYPO3\FLOW3\Persistence\Repository
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
