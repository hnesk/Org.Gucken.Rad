<?php
namespace Org\Gucken\Rad\ViewHelpers;

use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Scope("prototype")
 */
class JsonArrayViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {


	public static $nesting = 0;


	/**
	 *
	 * @return string
	 */
	protected function render() {

		self::$nesting++;
		$fieldName = 'fields'.self::$nesting;
		$this->viewHelperVariableContainer->add(get_class($this), $fieldName, array());
		$this->renderChildren();
		$fields = $this->viewHelperVariableContainer->get(get_class($this), $fieldName);
		$this->viewHelperVariableContainer->remove(get_class($this), $fieldName);

		self::$nesting--;
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
			if (json_decode($value) !== null) {
				$value = json_decode($value);
			}
			$current = $value;
		}
		return $result;
	}
}
?>
