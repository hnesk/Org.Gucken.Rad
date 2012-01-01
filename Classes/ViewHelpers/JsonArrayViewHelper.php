<?php
namespace Org\Gucken\Rad\ViewHelpers;

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * @FLOW3\Scope("prototype")
 */
class JsonArrayViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * 
	 * @return string
	 */
	protected function render() {
		$this->viewHelperVariableContainer->add(get_class($this), 'fields', array());
		$this->renderChildren();
		$fields = $this->viewHelperVariableContainer->get(get_class($this), 'fields');		
		$this->viewHelperVariableContainer->remove(get_class($this), 'fields');		
		return json_encode($this->resolvePropertyPaths($fields));
	}
	
	/**
	 * Resolves array keys 
	 * 
	 * {a.b:1, a.c:2} => {a: {b:1, c:2}}
	 * 
	 * @param array $fields  
	 * @param array 
	 */
	protected function resolvePropertyPaths($fields) {
		$result = array();		
		foreach ($fields as $key => $value) {
			$current =& $result;
			$keyParts = explode('.', $key);
			foreach ($keyParts as $key) {
				if (!isset($current[$key])) {
					$current[$key] = array();
				}
				$current =& $current[$key];
			}
			$current = $value;
		}
		return $result;
	}
}
?>
