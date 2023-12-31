<?php declare(strict_types=1);
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
 * @package BrandCrockProductPopularity
 */
namespace Bc\BrandCrockProductPopularity\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Shopware\Storefront\Page\Product\ProductPageLoadedEvent;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\Framework\Struct\ArrayEntity;
use Doctrine\DBAL\Connection;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;

class Subscriber implements EventSubscriberInterface
{
    /**
     * @var Connection
     */
    private $connection;
    /**
     * @var SystemConfigService
     */
    private $systemconfigService;

    public function __construct(
         Connection $connection,
         SystemConfigService $SystemConfigService
    ) {
        $this->connection = $connection;
        $this->systemconfigService = $SystemConfigService;
    }

    public static function getSubscribedEvents(): array
    {
        return[
            ProductPageLoadedEvent::class => 'onProductsLoaded',
        ];
    }
    public function onProductsLoaded(ProductPageLoadedEvent $event)
    {
		  $active = $this->getConfig('active', $event->getSalesChannelContext());
        if($active == 0)
            return;
        $productId = $event->getPage()->getProduct()->getId();
        $date = date("Y-m-d");
        $countSales = $this->getConfig('countdays', $event->getSalesChannelContext());
        $countSales = ($countSales) ? $countSales : '15';
        $whereDate = date('Y-m-d',strtotime('-'.$countSales.'days',strtotime($date)));

        $query = $this->connection->createQueryBuilder()
            ->select('order_line_item.product_id as totalOrder , order_line_item.order_id , order_customer.email')
            ->from('order_line_item')
            ->innerJoin('order_line_item', 'order_customer', 'order_customer', 'order_customer.order_id = order_line_item.order_id')
            ->where('order_line_item.product_id = :productId')
            ->andWhere("order_line_item.created_at >= '$whereDate'")
            ->setParameter('productId', Uuid::fromHexToBytes($productId));
        $result = $query->execute()->fetchAll();
        if($result) {
            foreach ($result as $k => $value){
                $email[] = $value['email'];
            }
            $count = count(array_unique($email));
            if($count) {
                $event->getPage()->addExtension("bcOrderCouent", new ArrayEntity(["count"=> $count , "days" => $countSales]));
            }
        }
    }
    /**
     * @param $key
     * @param SalesChannelContext $salesChannelContext
     * @return array|bool|float|int|string|null
     */
    private function getConfig($key, SalesChannelContext $salesChannelContext)
    {
        return $this->systemconfigService->get(
            'BrandCrockProductPopularity.config.'.$key,
            $salesChannelContext->getSalesChannel()->getId()
        );
    }
}
