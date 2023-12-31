<?php declare(strict_types=1);

namespace Laenen\PrismEditor;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsAnyFilter;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;

class LaenenPrismEditor extends Plugin
{
    public function uninstall(UninstallContext $uninstallContext): void
    {
        parent::uninstall($uninstallContext);

        if ($uninstallContext->keepUserData()) {
            return;
        }

        // Remove CMS blocks & slots
        /** @var EntityRepositoryInterface $cmsBlockRepository */
        $cmsBlockRepository = $this->container->get('cms_block.repository');
        /** @var EntityRepositoryInterface $cmsSlotRepository */
        $cmsSlotRepository = $this->container->get('cms_slot.repository');

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsAnyFilter('type', ['lae-prism-html']));

        $cmsSlotRepository->delete(
            array_values(
                $cmsSlotRepository->searchIds(
                    $criteria,
                    $uninstallContext->getContext()
                )->getData()
            ),
            $uninstallContext->getContext()
        );

        $cmsBlockRepository->delete(
            array_values(
                $cmsBlockRepository->searchIds(
                    $criteria,
                    $uninstallContext->getContext()
                )->getData()
            ),
            $uninstallContext->getContext()
        );
    }
}
