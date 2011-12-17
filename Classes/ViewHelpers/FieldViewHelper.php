<?php

namespace Org\Gucken\Rad\ViewHelpers;

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * @FLOW3\Scope("prototype")
 */
class FieldViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {

    
    /**
     * @FLOW3\Inject
     * @var Org\Gucken\Rad\Service\ReflectionService
     */
    protected $repositoryReflectionService;

    /**
     * @FLOW3\Inject
     * @var \TYPO3\FLOW3\Object\ObjectManager
     */
    protected $objectManager;
    
    
    /**
     * Set the template variable given as $as to the current account
     *
     * @param $property string
     * @param $propertyValue object
     * @param $propertyName string
     * @return string
     */
    protected function render($property = null,$propertyValue = null, $propertyName = '') {
        if (\is_null($propertyValue)) {
            $propertyName = $property;
            $propertyValue = $this->getPropertyValue($property);            
        }

        if (\is_object($propertyValue)) {           
            $repository = $this->repositoryReflectionService->getRepositoryFor($propertyValue);
            if ($repository) {
                return $this->renderSelect($propertyName, $propertyValue, $repository->findAll());
            } else {
                return $this->renderTextfield($propertyName, $propertyValue);
            }

        } else {
            return $this->renderTextfield($propertyName, $propertyValue);
        }
        
    }

    protected function renderTextfield($propertyName, $propertyValue) {
        return $this->rowTemplate(
            $propertyName,
            $this->callViewHelper(
                'TYPO3\Fluid\ViewHelpers\Form\TextfieldViewHelper',
                array(
                    'property' => $propertyName,
                    'id' => 'rad.'.$propertyName,
                )
            )
        );
    }


    protected function renderSelect($propertyName, $propertyValue, $options) {
        return $this->rowTemplate(
            $propertyName,
            $this->callViewHelper(
                'TYPO3\Fluid\ViewHelpers\Form\SelectViewHelper',
                array(
                    'property' => $propertyName,
                    'id' => 'rad.'.$propertyName,
                    'options' => $options,
                    'sortByOptionLabel' => true
                )
            )
         );

    }

    protected function rowTemplate($fieldName,$fieldHtml) {
        return '<dt><label for="rad.'.$fieldName.'">'.$fieldName.':</label></dt><dd>'.$fieldHtml.'</dd>';
    }

    protected function callViewHelper($name, $arguments) {
        $viewHelper = $this->objectManager->get($name);
        $viewHelper->setRenderingContext($this->renderingContext);
        $viewHelper->setArguments($arguments);
        $viewHelper->initialize();
        return $viewHelper->render();
    }


    /**
     * Get the current property of the object bound to this form.
     *
     * @return mixed Value
     * @author Bastian Waidelich <bastian@typo3.org>
     */
    protected function getPropertyValue($propertyName) {

        $formObject = $this->viewHelperVariableContainer->get('Org\Gucken\Rad\ViewHelpers\FieldsViewHelper', 'fieldsObject');
        return \TYPO3\FLOW3\Reflection\ObjectAccess::getPropertyPath($formObject, $propertyName);
    }

}

?>
