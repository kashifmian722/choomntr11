<?php declare(strict_types=1);

namespace Shopware\Production\Merchants\Storefront\Cms;

use Shopware\Core\Content\Cms\Aggregate\CmsBlock\CmsBlockCollection;
use Shopware\Core\Content\Cms\Aggregate\CmsBlock\CmsBlockEntity;
use Shopware\Core\Content\Cms\Aggregate\CmsSection\CmsSectionCollection;
use Shopware\Core\Content\Cms\Aggregate\CmsSection\CmsSectionEntity;
use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotCollection;
use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Content\Cms\CmsPageEntity;
use Shopware\Core\Content\Cms\DataResolver\CmsSlotsDataResolver;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;
use Shopware\Core\Content\Cms\SalesChannel\SalesChannelCmsPageLoaderInterface;
use Shopware\Core\Content\Cms\SalesChannel\Struct\ImageStruct;
use Shopware\Core\Content\Cms\SalesChannel\Struct\TextStruct;
use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SalesChannel\SalesChannelEntity;
use Shopware\Production\Organization\System\Organization\OrganizationEntity;
use Symfony\Component\HttpFoundation\Request;

class SalesChannelCmsPageLoader implements SalesChannelCmsPageLoaderInterface
{
    /**
     * @var SalesChannelCmsPageLoaderInterface
     */
    private $coreService;

    /**
     * @var CmsSlotsDataResolver
     */
    private $cmsSlotsDataResolver;

    public function __construct(SalesChannelCmsPageLoaderInterface $coreService, CmsSlotsDataResolver $cmsSlotsDataResolver)
    {
        $this->coreService = $coreService;
        $this->cmsSlotsDataResolver = $cmsSlotsDataResolver;
    }

    public function load(Request $request, Criteria $criteria, SalesChannelContext $context, ?array $config = null, ?ResolverContext $resolverContext = null): EntitySearchResult
    {
        $navigationId = $request->attributes->get('navigationId', $context->getSalesChannel()->getNavigationCategoryId());

        /** @var OrganizationEntity|null $organization */
        $organization = $context->getSalesChannel()->getExtension('organization');
        $cmsPageId = $request->attributes->get('id');

        // Check if request is for the main navigation category
        if ($navigationId === $context->getSalesChannel()->getNavigationCategoryId()) {
            // Load the corresponding CMS page using the main navigation category ID
            $cmsPage = $this->loadCmsPageForMainNavigation($context);

            // If a specific CMS page is assigned to the main navigation category, return it
            if ($cmsPage) {
                $result = new EntitySearchResult(1, new EntityCollection([$cmsPage]), null, $criteria, $context->getContext());
                return $result;
            }
        }

        // If no specific CMS page is assigned to the main navigation category, continue loading the requested page
        return $this->coreService->load($request, $criteria, $context, $config, $resolverContext);
    }

    private function loadCmsPageForMainNavigation(SalesChannelContext $context): ?CmsPageEntity
    {
        // Implement your logic here to load the corresponding CMS page using the main navigation category ID
        // For example, you could query the database to find the CMS page assigned to the main navigation category
        // and return the CMS page entity if found.

        $cmsPage = null; // Your logic to load the CMS page using the main navigation category ID
        return $cmsPage;
    }

    public function getCmsPageIdForMainNavigation(SalesChannelContext $context): ?string
    {
        // Implement your logic here to get the ID of the CMS page assigned to the main navigation category
        // For example, you could query the database to find the ID of the CMS page assigned to the main navigation category
        // and return it if found.

        $cmsPageId = null; // Your logic to get the CMS page ID for the main navigation category
        return $cmsPageId;
    }

    // ... (other existing methods remain the same)

    private function loadStartPage(Request $request, Criteria $criteria, SalesChannelContext $context, ?ResolverContext $resolverContext, OrganizationEntity $organization): EntitySearchResult
    {
        // Existing implementation of the loadStartPage method remains unchanged
        // ...
    }

    private function addHeroImage(CmsPageEntity $cmsPage, OrganizationEntity $organization): void
    {
        // Existing implementation of the addHeroImage method remains unchanged
        // ...
    }

    private function addText(CmsPageEntity $cmsPage, OrganizationEntity $organization, SalesChannelEntity $salesChannel): void
    {
        // Existing implementation of the addText method remains unchanged
        // ...
    }

    private function addMerchantListing(CmsPageEntity $cmsPage): void
    {
        // Existing implementation of the addMerchantListing method remains unchanged
        // ...
    }
}
