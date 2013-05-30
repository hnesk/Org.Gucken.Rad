<?php
namespace Org\Gucken\Rad\ViewHelpers;

use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Scope("prototype")
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
            return '!' .$this->renderChildren().'!'.\TYPO3\Flow\var_dump($object,'',true);
	}

}
?>
