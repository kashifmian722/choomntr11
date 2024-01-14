<?php declare(strict_types=1);

namespace Shopware\Production\Merchants\Content\Merchant\Api;

use OpenApi\Annotations as OA;
use Shopware\Core\Content\Category\CategoryEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\MultiFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\NotFilter;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Shopware\Core\Framework\Validation\DataBag\QueryDataBag;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"merchant-api"})
 */
class IndustriesController
{
    /**
     * @var EntityRepositoryInterface
     */
    private $categoryRepository;

    public function __construct(EntityRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @OA\Get(
     *      path="/industries",
     *      description="List all available industries",
     *      operationId="loadindustries",
     *      tags={"Merchant"},
     *      @OA\Response(
     *          response="200",
     *          @OA\JsonContent(
     *              ref="#/definitions/IndustriesResponse"
     *          )
     *     )
     * )
     * @Route(name="merchant-api.industries.load", path="/merchant-api/v{version}/industries")
     */
    public function load(SalesChannelContext $context): JsonResponse
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('visible', true));
        $criteria->addFilter(new EqualsFilter('level', 2));
        $criteria->addFilter(new NotFilter(MultiFilter::CONNECTION_AND, [new EqualsFilter('parentId', null)]));

        $categories = $this->categoryRepository
            ->search($criteria, $context->getContext())->getElements();

        $responseData = [];

        /** @var CategoryEntity $category */
        foreach ($categories as $category) {
            $responseData[] = [
                'id' => $category->getId(),
                'name' => $category->getTranslation('name'),
            ];
        }

        return new JsonResponse($responseData);
    }

    /**
     * @OA\Get(
     *      path="/sub-category",
     *      description="List all available sub categories",
     *      operationId="loadsubcategories",
     *      tags={"Merchant"},
     *      @OA\Response(
     *          response="200",
     *          @OA\JsonContent(
     *              ref="#/definitions/IndustriesResponse"
     *          )
     *     )
     * )
     * @Route(name="merchant-api.subcategory.load", path="/merchant-api/v{version}/sub-category")
     */
    public function sub_category(SalesChannelContext $context, QueryDataBag $queryDataBag): JsonResponse
    {
        if (!$queryDataBag->get('parent')) {
            return new JsonResponse(['success' => false]);
            //return new RedirectResponse(getenv('MERCHANT_PORTAL'));
        }
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('visible', true));
        $criteria->addFilter(new EqualsFilter('parentId', $queryDataBag->get('parent')));
        $criteria->addFilter(new NotFilter(MultiFilter::CONNECTION_AND, [new EqualsFilter('parentId', null)]));

        $categories = $this->categoryRepository
            ->search($criteria, $context->getContext())->getElements();

        $responseData = [];

        /** @var CategoryEntity $category */
        foreach ($categories as $category) {
            $responseData[] = [
                'id' => $category->getId(),
                'name' => $category->getTranslation('name'),
            ];
        }

        return new JsonResponse($responseData);
    }
}
