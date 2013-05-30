<?php
namespace Org\Gucken\Rad\ViewHelpers;

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * @FLOW3\Scope("prototype")
 */
class FieldsViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * 
	 *
	 * @param $object Object
         * @param $properties array
	 * @return string
	 */
	protected function render($object = null,$properties = array()) {
            $this->viewHelperVariableContainer->add(get_class($this), 'fieldsObject', $object);
            return 'TODO: implement '.__METHOD__;
            return '!' .$this->renderChildren().'!'.\TYPO3\FLOW3\var_dump($object,'',true);
	}

}
?>
