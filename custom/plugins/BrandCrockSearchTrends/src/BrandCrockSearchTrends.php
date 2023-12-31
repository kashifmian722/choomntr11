<?php declare(strict_types=1);
namespace Bc\BrandCrockSearchTrends;

use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Doctrine\DBAL\Connection;

/**
 * To plugin root file.
 *
 * Copyright (C) BrandCrock GmbH. All rights reserved
 *
 * If you have found this script useful a small
 * recommendation as well as a comment on our
 * home page(https://brandcrock.com/)
 * would be greatly appreciated.
 *
 * @author BrandCrock GmbH
 * @package BrandCrockSearchTrends
 */

class BrandCrockSearchTrends extends Plugin
{
    /**
     * @param UninstallContext $uninstallContext
     */
    public function uninstall(UninstallContext $uninstallContext): void
    {
        if ($uninstallContext->keepUserData()) {
            parent::uninstall($uninstallContext);
            return;
        }
        $connection = $this->container->get(Connection::class);
        $connection->executeQuery("DELETE FROM system_config WHERE configuration_key like '%BrandCrockSearchTrends%'");
    }
}
