<?php
namespace Org\Gucken\Rad\ViewHelpers;

use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Scope("prototype")
 */
class JsonFieldViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @param string $key
	 * @param boolean $forceOutput
	 */
	protected function render($key, $forceOutput = false) {

		$fieldName = 'fields'.JsonArrayViewHelper::$nesting;

		$parentClass = 'Org\Gucken\Rad\ViewHelpers\JsonArrayViewHelper';
		$fields = $this->viewHelperVariableContainer->get($parentClass, $fieldName);
		$output = $this->renderChildren();
		if ($output || $forceOutput) {
			$fields[$key] = $output;
		}
		$this->viewHelperVariableContainer->remove($parentClass, $fieldName);
		$this->viewHelperVariableContainer->add($parentClass, $fieldName, $fields);
	}

}
?>
