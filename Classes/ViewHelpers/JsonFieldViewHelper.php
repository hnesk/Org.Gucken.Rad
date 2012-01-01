<?php
namespace Org\Gucken\Rad\ViewHelpers;

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * @FLOW3\Scope("prototype")
 */
class JsonFieldViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @param string $key
	 * @param boolean $forceOutput
	 */
	protected function render($key, $forceOutput = false) {
		$parentClass = 'Org\Gucken\Rad\ViewHelpers\JsonArrayViewHelper';
		$fields = $this->viewHelperVariableContainer->get($parentClass, 'fields');
		$output = $this->renderChildren();
		if ($output || $forceOutput) {
			$fields[$key] = $output;
		}
		$this->viewHelperVariableContainer->remove($parentClass, 'fields');
		$this->viewHelperVariableContainer->add($parentClass, 'fields', $fields);
	}

}
?>
