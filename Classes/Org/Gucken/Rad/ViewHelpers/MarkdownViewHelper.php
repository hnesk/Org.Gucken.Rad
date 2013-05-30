<?php
namespace Org\Gucken\Rad\ViewHelpers;

use TYPO3\Flow\Annotations as Flow;

/**
 */
class MarkdownViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Set the template variable given as $as to the current account
	 *
	 * @param $as string
	 * @return string
	 */
	protected function render() {
		$output = $this->renderChildren();
		return Markdown($output);
	}

}
?>
