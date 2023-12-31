<?php declare(strict_types=1);
namespace Bc\BrandCrockSearchTrends\Subscriber;


use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsAnyFilter;
use Shopware\Core\System\SalesChannel\Entity\SalesChannelEntityLoadedEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Pagelet\Header\HeaderPageletLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Shopware\Core\Framework\Struct\ArrayEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\RangeFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Aggregation\Metric\CountAggregation;

/**
 * To plugin Subscriber file.
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

class BrandCrockSearchTrendsSubscriber implements EventSubscriberInterface
{

    private const TREND_THRESHOLD = 0;

    /**
     * @var SystemConfigService
     */
    private $systemConfigService;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * BrandCrockSearchTrendsSubscriber constructor.
     * @param SystemConfigService $systemConfigService
     * @param ContainerInterface $container
     */
    public function __construct(
        SystemConfigService $systemConfigService,
        ContainerInterface $container
    ) {
        $this->systemConfigService          = $systemConfigService;
        $this->container                    = $container;
    }

    /**
     * Subscriber Events
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            HeaderPageletLoadedEvent::class => 'prepareSearchTrends',
            'sales_channel.product.loaded'  => 'onSalesChannelProductLoaded'
        ];
    }

    /**
     * Handles the searching process
     * @param HeaderPageletLoadedEvent $event
     */
    public function prepareSearchTrends(HeaderPageletLoadedEvent $event): void
    {
        //Fetch our plugin configuration
        $brandCrockSearchTrendsConfig   =   $this->systemConfigService->get('BrandCrockSearchTrends.config',$event->getContext()->getSource()->getSalesChannelId());

        $brandCrockSearchTrends         =  [];

        //Check for Mode Configuration
        if ($brandCrockSearchTrendsConfig['searchMode'] == 'manual') {
            // No need of this key anymore so removing it
            unset($brandCrockSearchTrendsConfig['searchMode']);
            unset($brandCrockSearchTrendsConfig['trendLabelling']);

            $searchCollection   =   [];
            // Making a clean assignment
            foreach ($brandCrockSearchTrendsConfig as $config => $searchTrend) {
                preg_match('!([a-zA-Z]+)(\d+)!', $config, $keyValue);
                $searchCollection[$keyValue[2]][$keyValue[1]]   =   $searchTrend;
            }
            // Filtering the assignment
            if (count($searchCollection) != 0) {
                ksort($searchCollection);
                $position   =   0;
                foreach ($searchCollection as $value) {
                    if (!empty($value['searchTrendLabel'])) {
                        $brandCrockSearchTrends[$position]['bcStl'] =   $value['searchTrendLabel'];
                        $brandCrockSearchTrends[$position]['bcStu'] =   (!empty($value['searchTrendUrl']) && filter_var($value['searchTrendUrl'], FILTER_VALIDATE_URL)) ? $value['searchTrendUrl'] : '#';
                        $position++;
                    }
                }
            }
        } else {
            //Process Automation
            $session = $event->getRequest()->getSession();
            if (! $session->has('brandCrockSearchTrendsList') || ($session->has('brandCrockSearchTrendsList') && $session->get('brandCrockSearchTrendsListLang') != $event->getContext()->getLanguageId())) {
                $criteria       =   new Criteria();
                $criteria->addFilter(new RangeFilter('createdAt', [
                    RangeFilter::GTE => date('Y-m-d', strtotime('-7 day'))
                ]));
                $criteria->addAssociation('product');
                $criteria->addAssociation('product.visibilities');
                $criteria->setLimit(100);
                $trendyProducts =   $this->container->get('order_line_item.repository')
                    ->search($criteria, $event->getContext());
                $productsCollection =   [];
                foreach ($trendyProducts as $trendyProduct) {										
					if( 
						! empty($trendyProduct->get('productId')) && $trendyProduct->get('type') == 'product' &&
						$trendyProduct->getProduct()->getActive() == 1
					 ) {
						$visibilities	=	$trendyProduct->getProduct()->getVisibilities()->getElements();
						$canVisible	=	false;
						if( ! empty( $visibilities ) ) {
							foreach( $visibilities as $visible ) {
								if( $visible->getVisibility() == 30 &&  $visible->getSalesChannelId() == $event->getContext()->getSource()->getSalesChannelId() ) {
									$canVisible	=	true;
								}
							}
						}
						if( $canVisible	) { 
							if (! isset($productsCollection[$trendyProduct->get('productId')])) {
								$productsCollection[$trendyProduct->get('productId')]['count']  =   0;
								$productsCollection[$trendyProduct->get('productId')]['label']  =   $trendyProduct->get('label');
								$productsCollection[$trendyProduct->get('productId')]['id']     =   $trendyProduct->get('productId');
							}
							$productsCollection[$trendyProduct->get('productId')]['count']++;
						}
					}
                }
                usort($productsCollection, function ($product1, $product2) {
                    return $product2['count'] <=> $product1['count'];
                });
                $selectedProducts   =   ['productIds'   => [] ];
                foreach ($productsCollection as $position => $product) {
                    array_push($selectedProducts['productIds'], $product['id']);
                    $brandCrockSearchTrends[$position]['bcStl'] =   $product['label'];
                    $brandCrockSearchTrends[$position]['bcStu'] =   '#';
                    $selectedProducts[$product['id']]           =   $position;
                    if ($position == 4) {
                        break;
                    }
                }
                if(count($selectedProducts['productIds']) > 0) {
                    $productCriteria  =   new Criteria();
                    $productCriteria->addFilter(new EqualsAnyFilter('id', $selectedProducts['productIds']));
                    $productCriteria->addAssociation('translations');
                    $productCriteria->getAssociation('translations')->addFilter(new EqualsFilter('languageId', $event->getContext()->getLanguageId()));
                    $productCriteria->addAssociation('cover');
                    $products       =   $this->container->get('product.repository')->search($productCriteria, $event->getContext());                    
                    foreach ($products as $product) {
						$translation	=	$product->getTranslations()->first();
                        if( ! empty( $translation ) && ! empty( $translation->get('name') ) ) {
                            $brandCrockSearchTrends[$selectedProducts[$product->get('id')]]['bcStl'] =   $translation->get('name');
                        }
                        $brandCrockSearchTrends[$selectedProducts[$product->get('id')]]['cover'] =   $product->getCover();
                    }
                    $session->set('brandCrockSearchTrendsList', $brandCrockSearchTrends);
                    $session->set('brandCrockSearchTrendsListLang', $event->getContext()->getLanguageId());
                }
            } else {
                $brandCrockSearchTrends =   $session->get('brandCrockSearchTrendsList');
            }
        }
        $event->getPagelet()->addExtension("brand_crock_search_trends", new ArrayEntity(['trends'=>$brandCrockSearchTrends]));
    }

    /**
     * @param SalesChannelEntityLoadedEvent $event
     */
    public function onSalesChannelProductLoaded(SalesChannelEntityLoadedEvent $event): void
    {
        //Fetch our plugin configuration
        $brandCrockSearchTrendsConfig   =   $this->systemConfigService->get('BrandCrockSearchTrends.config',$event->getContext()->getSource()->getSalesChannelId());

        if( ! empty( $brandCrockSearchTrendsConfig['trendLabelling'] ) ) {
            $salesChannelProducts   =   $event->getEntities();
            foreach ($salesChannelProducts as $product) {
                $productCriteria = new Criteria();
                $productCriteria->addFilter(new RangeFilter('createdAt', [
                    RangeFilter::GTE => date('Y-m-d', strtotime('-7 day'))
                ]));
                $productCriteria->addFilter(new EqualsFilter('productId', $product->getId()));
                $productCriteria->addAggregation(
                    new CountAggregation('count-products','productId')
                );
                $productCriteria->setLimit(1);
                $maxProductPurchase = $this->container->get('order_line_item.repository')
                    ->search($productCriteria, $event->getContext());
                $aggregation = $maxProductPurchase->getAggregations()->get('count-products');
                if( $aggregation->getCount() > self::TREND_THRESHOLD ) {
                    $customFields   =   $product->getCustomFields();
                    $customFields['bcSearchTrending'] = 1;
                    $product->setCustomFields($customFields);
                }
            }
        }
    }
}
