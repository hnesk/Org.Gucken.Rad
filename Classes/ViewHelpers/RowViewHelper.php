<?php

namespace Org\Gucken\Rad\ViewHelpers;

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * @FLOW3\Scope("prototype")
 */
class RowViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 *
	 * @var \TYPO3\FLOW3\I18n\Translator
	 * @FLOW3\Inject
	 */
	protected $translator;

    /**
     * Set the template variable given as $as to the current account
     *
     * @param $property string
     * @param $label string
	 * @param $id string
	 * @param $isPropertyBoundToForm boolean
	 * @return string
     */
    protected function render($property = '', $label='',$id = '',$isPropertyBoundToForm = true) {
        return $this->rowTemplate(
			$id,
            $property,
			$label,
			$this->renderChildren(),
			$isPropertyBoundToForm
        );


    }

    protected function rowTemplate($id, $property, $fieldLabel, $fieldHtml, $isPropertyBoundToForm = true) {
		$mappingResults = $this->getMappingResultsForProperty($property, $isPropertyBoundToForm);
		$propertyErrors = $mappingResults->getErrors();
		$propertyWarnings = $mappingResults->getWarnings();

		$problems = $propertyErrors + $propertyWarnings;

		$errorString = '';
		foreach ($problems as $error) {
				/* @var $error \TYPO3\FLOW3\Error\Error */
				try {
					$errorMessage = $this->translator->translateById($error->getCode(), $error->getArguments(), NULL, NULL, 'ValidationErrors', 'Org.Gucken.Bielefeld');
				} catch (\Exception $e) {
					$errorMessage = (string)$error;
				}
				if ($errorMessage == $error->getCode()) {
					$errorMessage = (string)$error;
				}
				$errorString .= '<p class="help-block error">'.$errorMessage.'</p>';
		}


        return
			'<div class="control-group'.(count($propertyErrors) > 0 ? ' error' : '') . (count($propertyWarnings) > 0 ? ' warning' : '') . '">
				<label for="'.$id.'">'.$fieldLabel.':</label>
				<div class="controls">'.$fieldHtml.$errorString.'</div>
			</div>';
    }

	/**
	 * Get errors for the property and form name of this view helper
	 * @param $property string
	 * @param $isPropertyBoundToForm boolean
	 * @return array<\TYPO3\FLOW3\Error\Error> Array of errors
	 */
	protected function getMappingResultsForProperty($property, $isPropertyBoundToForm = true) {
		if (!$this->isObjectAccessorMode()) {
			return new \TYPO3\FLOW3\Error\Result();
		}
		$originalRequestMappingResults = $this->controllerContext->getRequest()->getOriginalRequestMappingResults();

		if ($isPropertyBoundToForm) {
			$formObjectName = $this->viewHelperVariableContainer->get('TYPO3\Fluid\ViewHelpers\FormViewHelper', 'formObjectName');
			return $originalRequestMappingResults->forProperty($formObjectName)->forProperty($property);
		} else {
			return $originalRequestMappingResults->forProperty($property);
		}

	}

	/**
	 * Internal method which checks if we should evaluate a domain object or just output arguments['name'] and arguments['value']
	 *
	 * @return boolean TRUE if we should evaluate the domain object, FALSE otherwise.
	 */
	protected function isObjectAccessorMode() {
		return $this->hasArgument('property')
			&& $this->viewHelperVariableContainer->exists('TYPO3\Fluid\ViewHelpers\FormViewHelper', 'formObjectName');
	}


}

?>
