<?php declare(strict_types=1);

namespace CoeGoogleSiteVerificationSw6;

use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Shopware\Core\Framework\Plugin\Context\InstallContext;

/**
 * Class CoeGoogleSiteVerificationSw6
 * @package CoeGoogleSiteVerificationSw6
 * @author Jeffry Block <jeffry.block@codeenterprise.de>
 */
class CoeGoogleSiteVerificationSw6 extends Plugin {

    /**
     * @param InstallContext $context
     * @author Jeffry Block <jeffry.block@codeenterprise.de>
     * @throws \Shopware\Core\Framework\DataAbstractionLayer\Exception\InconsistentCriteriaIdsException
     */
    public function install(InstallContext $context): void
    {
        parent::install($context);
    }

    /**
     * @param UninstallContext $context
     * @author Jeffry Block <jeffry.block@codeenterprise.de>
     */
    public function uninstall(UninstallContext $context): void
    {
        parent::uninstall($context);

        if ($context->keepUserData()) {
            return;
        }
    }
}