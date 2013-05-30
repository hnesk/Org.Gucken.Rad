<?php
namespace Org\Gucken\Rad;

use \TYPO3\Flow\Package\Package as BasePackage;

use Doctrine\ORM\Mapping as ORM;
use TYPO3\Flow\Annotations as Flow;

/**
 * Package base class of the Org.Gucken.Rad package.
 *
 * @Flow\Scope("singleton")
 */
class Package extends BasePackage {
    /**
     * Invokes custom PHP code directly after the package manager has been initialized.
     *
     * @param \TYPO3\Flow\Core\Bootstrap $bootstrap The current bootstrap
     * @return void
     */
    public function boot(\TYPO3\Flow\Core\Bootstrap $bootstrap) {
        require_once $this->packagePath.'Resources/Private/PHP/PHP-Markdown-1.0.1o/markdown.php';

    }	
}
?>