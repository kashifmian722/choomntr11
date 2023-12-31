<?php declare(strict_types=1);
/**
 * To plugin Bootstrap file.
 *
 * Copyright (C) BrandCrock GmbH. All rights reserved
 *
 * If you have found this script useful a small
 * recommendation as well as a comment on our
 * home page(https://brandcrock.com/)
 * would be greatly appreciated.
 *
 * @author BrandCrock GmbH
 * @package BrandCrockProductPopularity
 */
namespace Bc\BrandCrockProductPopularity;

use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\ContainsFilter;

class BrandCrockProductPopularity extends Plugin
{
    public function Install(InstallContext $context): void
    {
        parent::Install($context);

    }
    public function uninstall(UninstallContext $uninstallContext): void
    {
        parent::uninstall($uninstallContext);
        if (!$uninstallContext->keepUserData()) {
            $this->removeConfiguration($uninstallContext->getContext());
        }
    }
    private function removeConfiguration(Context $context): void
    {
        /** @var EntityRepositoryInterface $systemConfigRepository */
        $systemConfigRepository = $this->container->get('system_config.repository');

        $criteria = (new Criteria())
            ->addFilter(new ContainsFilter('configurationKey', 'BrandCrockProductPopularity.'));
        $idSearchResult = $systemConfigRepository->searchIds($criteria, $context);

        if (!$idSearchResult->getTotal()) {
            return;
        }

        $ids = array_map(static function ($id) {
            return ['id' => $id];
        }, $idSearchResult->getIds());

        $systemConfigRepository->delete($ids, $context);
    }
}
