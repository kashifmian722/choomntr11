<?php declare(strict_types=1);

namespace Webkul\GPA;

use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use  Shopware\Core\Framework\Plugin\Context\UninstallContext;

class WebkulGPA extends Plugin
{
    public function uninstall(UninstallContext $uninstallContext): void
    {
        parent:: uninstall($uninstallContext);

        if ($uninstallContext->keepUserData()) {
            return;
        }
    }

    public function install(InstallContext $installContext): void
    {
        
    }
}