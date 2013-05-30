<?php
namespace Org\Gucken\Rad;

use \TYPO3\FLOW3\Package\Package as BasePackage;

use Doctrine\ORM\Mapping as ORM;
use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * Package base class of the Org.Gucken.Rad package.
 *
 * @FLOW3\Scope("singleton")
 */
class Package extends BasePackage {
    /**
     * Invokes custom PHP code directly after the package manager has been initialized.
     *
     * @param \TYPO3\FLOW3\Core\Bootstrap $bootstrap The current bootstrap
     * @return void
     */
    public function boot(\TYPO3\FLOW3\Core\Bootstrap $bootstrap) {
        require_once $this->packagePath.'Resources/Private/PHP/PHP-Markdown-1.0.1o/markdown.php';

    }	
}
?>