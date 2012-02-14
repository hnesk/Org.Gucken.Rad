<?php

namespace Org\Gucken\Rad\ViewHelpers;

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * @FLOW3\Scope("prototype")
 */
class RowViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {

    
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
    protected function render($property = '', $label='') {
        return $this->rowTemplate(
            $property,
			$label,
			$this->renderChildren()
        );

        
    }

    protected function rowTemplate($fieldName,$fieldLabel, $fieldHtml) {
        return 
			'<div class="control-group">
				<label for="'.$fieldName.'">'.$fieldLabel.':</label>
				<div class="controls">'.$fieldHtml.'</div>
			</div>';
    }


}

?>
