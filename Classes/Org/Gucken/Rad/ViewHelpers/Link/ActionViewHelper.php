<?php
namespace Org\Gucken\Rad\ViewHelpers\Link;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Fluid\Core\ViewHelper\TagBuilder;
use TYPO3\Fluid\ViewHelpers\Link\ActionViewHelper as OriginalActionViewHelper;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Fluid".                 *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */


/**
 * A view helper for creating links to actions.
 *
 * = Examples =
 *
 * <code title="Defaults">
 * <f:link.action>some link</f:link.action>
 * </code>
 * <output>
 * <a href="currentpackage/currentcontroller">some link</a>
 * (depending on routing setup and current package/controller/action)
 * </output>
 *
 * <code title="Additional arguments">
 * <f:link.action action="myAction" controller="MyController" package="YourCompanyName.MyPackage" subpackage="YourCompanyName.MySubpackage" arguments="{key1: 'value1', key2: 'value2'}">some link</f:link.action>
 * </code>
 * <output>
 * <a href="mypackage/mycontroller/mysubpackage/myaction?key1=value1&amp;key2=value2">some link</a>
 * (depending on routing setup)
 * </output>
 *
 * @api
 */
class ActionViewHelper extends OriginalActionViewHelper {

    /**
     * @var string
     */
    protected $tagName = 'form';

    /**
     * @Flow\Inject
     * @var \TYPO3\Flow\Security\Context
     */
    protected $securityContext;


    /**
     * Initialize arguments
     *
     * @return void
     * @api
     */
    public function initializeArguments() {
        $this->registerUniversalTagAttributes();
        $this->registerTagAttribute('name', 'string', 'Specifies the name of an anchor');
        $this->registerTagAttribute('target', 'string', 'Specifies where to open the linked document');
    }


    /**
     * Render the link.
     *
     * @param string $action Target action
     * @param array $arguments Arguments
     * @param string $controller Target controller. If NULL current controllerName is used
     * @param string $package Target package. if NULL current package is used
     * @param string $subpackage Target subpackage. if NULL current subpackage is used
     * @param string $section The anchor to be added to the URI
     * @param string $format The requested format, e.g. ".html"
     * @param array $additionalParams additional query parameters that won't be prefixed like $arguments (overrule $arguments)
     * @param boolean $addQueryString If set, the current query parameters will be kept in the URI
     * @param array $argumentsToBeExcludedFromQueryString arguments to be removed from the URI. Only active if $addQueryString = TRUE
     * @return string The rendered link
     * @throws \TYPO3\Fluid\Core\ViewHelper\Exception
     * @api
     */
	public function render($action, $arguments = array(), $controller = NULL, $package = NULL, $subpackage = NULL, $section = '', $format = '',  array $additionalParams = array(), $addQueryString = FALSE, array $argumentsToBeExcludedFromQueryString = array()) {
		$uriBuilder = $this->controllerContext->getUriBuilder();
        $attributes = $this->tag->getAttributes();
        foreach ($attributes as $attributeName => $dummy) {
            $this->tag->removeAttribute($attributeName);
        }
		try {
			$uri = $uriBuilder
				->reset()
				->setSection($section)
				->setCreateAbsoluteUri(TRUE)
				->setArguments($additionalParams)
				->setAddQueryString($addQueryString)
				->setArgumentsToBeExcludedFromQueryString($argumentsToBeExcludedFromQueryString)
				->setFormat($format)
				->uriFor($action, $arguments, $controller, $package, $subpackage);
			$this->tag->addAttribute('action', $uri);
            $this->tag->addAttribute('method', 'post');
            $this->tag->addAttribute('class', 'postlink');
		} catch (\TYPO3\Flow\Exception $exception) {
			throw new \TYPO3\Fluid\Core\ViewHelper\Exception($exception->getMessage(), $exception->getCode(), $exception);
		}

		$this->tag->setContent(
            '<div style="display: none">'.
            $this->renderCsrfTokenField().
            '</div>'.
            $this->renderSubmit($attributes)
        );
		$this->tag->forceClosingTag(TRUE);

		return $this->tag->render();
	}

    /**
     * @param array $attributes
     * @return string
     */
    protected function renderSubmit($attributes = array()) {
        $formTag = new TagBuilder('button', $this->renderChildren());
        $formTag->addAttribute('type','submit');
        $formTag->addAttributes($attributes);
        $formTag->forceClosingTag(TRUE);
        return $formTag->render();
    }


    /**
     * Render the a hidden field with a CSRF token
     *
     * @return string the CSRF token field
     */
    protected function renderCsrfTokenField() {
        if (!$this->securityContext->isInitialized()) {
            return '';
        }
        $csrfToken = $this->securityContext->getCsrfProtectionToken();
        return '<input type="hidden" name="__csrfToken" value="' . htmlspecialchars($csrfToken) . '" />' . chr(10);
    }

}


?>
