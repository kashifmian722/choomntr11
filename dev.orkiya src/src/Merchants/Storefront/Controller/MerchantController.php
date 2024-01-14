<?php declare(strict_types=1);

namespace Shopware\Production\Merchants\Storefront\Controller;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\MultiFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\NotFilter;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\System\SalesChannel\Entity\SalesChannelRepositoryInterface;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\Content\Product\ProductCollection;
use Shopware\Production\Merchants\Content\Merchant\MerchantAvailableFilter;
use Shopware\Production\Merchants\Content\Merchant\MerchantEntity;
use Shopware\Production\Merchants\Events\MerchantPageCriteriaEvent;
use Shopware\Production\Merchants\Storefront\Page\MerchantPage;
use Shopware\Storefront\Controller\StorefrontController;
use Shopware\Storefront\Page\GenericPageLoader;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Shopware\Storefront\Framework\Routing\Router;

/**
 * @RouteScope(scopes={"storefront"})
 */
class MerchantController extends StorefrontController
{
    /**
     * @var SalesChannelRepositoryInterface
     */
    private $productRepository;

    /**
     * @var EntityRepositoryInterface
     */
    private $merchantRepository;

    /**
     * @var GenericPageLoader
     */
    private $genericPageLoader;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var EntityRepositoryInterface
     */
    private $categoryRepository;

    private $sub_categories;

    public function __construct(
        SalesChannelRepositoryInterface $productRepository,
        EntityRepositoryInterface $merchantRepository,
        GenericPageLoader $genericPageLoader,
        EventDispatcherInterface $eventDispatcher,
        EntityRepositoryInterface $categoryRepository
    ) {
        $this->productRepository = $productRepository;
        $this->merchantRepository = $merchantRepository;
        $this->genericPageLoader = $genericPageLoader;
        $this->eventDispatcher = $eventDispatcher;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route(name="storefront.merchant.detail", path="/merchant/{id}")
     */
    public function detail(Request $request, string $id, SalesChannelContext $context): Response
    {
        $page = $this->genericPageLoader->load($request, $context);
        $page = MerchantPage::createFrom($page);
        $page->setMerchant($this->loadMerchant($id, $context));

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('visible', true));
        $criteria->addFilter(new EqualsFilter('parentId', $page->getMerchant()->getCustomFields()['main_category']));
        $criteria->addFilter(new NotFilter(MultiFilter::CONNECTION_AND, [new EqualsFilter('parentId', null)]));

        $categories = $this->categoryRepository
            ->search($criteria, $context->getContext())->getElements();

        $responseData = [];

        /** @var CategoryEntity $category */
        foreach ($categories as $category) {
            if(in_array($category->getId(), $this->sub_categories)){
                $responseData[] = [
                    'id' => $category->getId(),
                    'name' => $category->getTranslation('name'),
                ];
            }
        }

        $vars = [
            'page' => $page,
            'navigationTree' => $responseData
        ];

        return $this->renderStorefront('storefront/page/merchant/detail.html.twig', $vars);
    }


    /**
     * @Route(name="storefront.merchant.detail.category", path="/merchant/{id}/{cat_id}")
     */
    public function detail_by_category(Request $request, string $id, string $cat_id, SalesChannelContext $context): Response
    {
        $page = $this->genericPageLoader->load($request, $context);
        $page = MerchantPage::createFrom($page);
        $page->setMerchant($this->loadMerchant($id, $context, $cat_id));

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('visible', true));
        $criteria->addFilter(new EqualsFilter('parentId', $page->getMerchant()->getCustomFields()['main_category']));
        $criteria->addFilter(new NotFilter(MultiFilter::CONNECTION_AND, [new EqualsFilter('parentId', null)]));

        $categories = $this->categoryRepository
            ->search($criteria, $context->getContext())->getElements();

        $responseData = [];

        /** @var CategoryEntity $category */
        foreach ($categories as $category) {
            if(in_array($category->getId(), $this->sub_categories)){
                $responseData[] = [
                    'id' => $category->getId(),
                    'name' => $category->getTranslation('name'),
                ];
            }
                
        }
        
        $vars = [
            'page' => $page,
            'navigationTree' => $responseData
        ];

        return $this->renderStorefront('storefront/page/merchant/detail.html.twig', $vars);
    }
    private function loadMerchant(string $id, SalesChannelContext $context, string $cat_id = null): MerchantEntity
    {

        $this->sub_categories = array();

        $criteria = new Criteria([$id]);
        $criteria->addAssociation('products');
        
        $criteria->addAssociation('cover.thumbnails');
        $criteria->addAssociation('country');
        $criteria->addAssociation('services');
        $criteria->addFilter(new MerchantAvailableFilter($context->getSalesChannel()->getId()));
        $this->eventDispatcher->dispatch(new MerchantPageCriteriaEvent($criteria));

        /** @var MerchantEntity|null $merchant */
        $merchant = $this->merchantRepository->search($criteria, $context->getContext())->first();
        if ($merchant === null) {
            throw new NotFoundHttpException(sprintf('Couldn\'t find merchant by id %s', $id));
        }

        $productCollection = $merchant->getProducts();
        if ($productCollection === null) {
            throw new NotFoundHttpException(
                sprintf('Couldn\'t find any products for the merchant with the id "%s"', $merchant->getId())
            );
        }

        $productIds = $productCollection->getIds();
        if (\count($productIds)) {
            $criteria = new Criteria($productIds);
            $criteria->addAssociation('categories');
            $products = $this->productRepository->search($criteria, $context)->getEntities();
            
            $tempProducts = new ProductCollection();
            if($cat_id){
                foreach($products as $prod){
                    if(in_array($cat_id, $prod->getCategories()->getIds())){
                        $tempProducts->add($prod);
                    }
                    foreach($prod->getCategories()->getIds() as $id){
                        array_push($this->sub_categories, $id);
                    }
                }
            }
            else{
                foreach($products as $prod){
                    foreach($prod->getCategories()->getIds() as $id){
                        array_push($this->sub_categories, $id);
                    }
                }
                $tempProducts = $products;
            }  
            $merchant->setProducts($tempProducts);
        }
        return $merchant;
    }

    /**
     * @Route("/merchant/{id}/check-in", name="storefront.merchant.check-in", defaults={"csrf_protected"=false})
     */
    public function checkin(Request $request, string $id, SalesChannelContext $context)
    {
        $customer = $context->getCustomer();
        if($customer){

            $criteria = new Criteria([$id]);
            $merchant = $this->merchantRepository->search($criteria, $context->getContext())->first();
            $checkins = 0;
            if(isset($merchant->getCustomFields()['checkin'])){
                $checkins = (int) $merchant->getCustomFields()['checkin'];
            }
            $this->merchantRepository->update([
                [
                    'id' => $id,
                    "customFields" => [
                        "checkin" => $checkins + 1
                    ]
                ]
            ], $context->getContext());
            $route = $request->headers->get('referer');
            return $this->redirect($route);
        }
        else{
            return  $this->redirect('https://orkiya.com/account/login');
        }
    }

    /**
     * @Route("/merchant/{id}/rate/{rate}", name="storefront.merchant.rate", defaults={"csrf_protected"=false})
     */
    public function rate(Request $request, string $id, string $rate, SalesChannelContext $context)
    {
        $customer = $context->getCustomer();
        if($customer){

            $criteria = new Criteria([$id]);
            $merchant = $this->merchantRepository->search($criteria, $context->getContext())->first();
            $rate = (int) $rate;
            $rating = 0;
            $person_rated = 0;
            if(isset($merchant->getCustomFields()['rating'])){
                $rating = (float) $merchant->getCustomFields()['rating'];
            }
            if(isset($merchant->getCustomFields()['person_rated'])){
                $person_rated = (int) $merchant->getCustomFields()['person_rated'];
            }
            
            $rating = $rating * $person_rated;
            $person_rated++;
            $rating = ($rating + $rate) / $person_rated;
            
            $this->merchantRepository->update([
                [
                    'id' => $id,
                    "customFields" => [
                        "rating" => $rating,
                        "person_rated" => $person_rated
                    ]
                ]
            ], $context->getContext());
            $route = $request->headers->get('referer');
            return $this->redirect($route);
        }
        else{
            return  $this->redirect('https://orkiya.com/account/login');
        }
    }


// src/Merchants/Content/Merchant/Api/MerchantProductController.php

/**
 * @Route(name="merchant-api.merchant.product.search", path="/merchant-api/v{version}/products/search", methods={"GET"})
 */
public function searchProducts(Request $request, MerchantEntity $merchant): JsonResponse
{
    $searchTerm = $request->query->get('search', '');

    $criteria = new Criteria();
    $criteria->addAssociation('merchants');
    $criteria->addFilter(new EqualsFilter('merchants.id', $merchant->getId()));
    $criteria->addFilter(new ContainsFilter('name', $searchTerm)); // Filter products by name containing the search term
    $criteria->addSorting(new FieldSorting('name', FieldSorting::ASCENDING));

    $products = $this->productRepository->search($criteria, Context::createDefaultContext());

    $productsArray = [];
    /** @var ProductEntity $product */
    foreach ($products as $product) {
        $productsArray[] = [
            'id' => $product->getId(),
            'name' => $product->getName(),
            // Add other product fields you want to include in the response
        ];
    }

    return new JsonResponse([
        'data' => $productsArray,
        'total' => $products->getTotal()
    ]);
}
  
  
        /**
     * @Route("/merchant/{id}/recommended", name="storefront.merchant.recommended", defaults={"csrf_protected"=false})
     */
    public function recommended(Request $request, string $id, SalesChannelContext $context)
    {
        $customer = $context->getCustomer();
        if($customer){

            $criteria = new Criteria([$id]);
            $merchant = $this->merchantRepository->search($criteria, $context->getContext())->first();
            $recommended = 0;
            if(isset($merchant->getCustomFields()['recommended'])){
                $recommended = (int) $merchant->getCustomFields()['recommended'];
            }
            $this->merchantRepository->update([
                [
                    'id' => $id,
                    "customFields" => [
                        "recommended" => $recommended + 1
                    ]
                ]
            ], $context->getContext());
            $route = $request->headers->get('referer');
            return $this->redirect($route);
        }
        else{
            return  $this->redirect('https://orkiya.com/account/login');
        }
    }

}
