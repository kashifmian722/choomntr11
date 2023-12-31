<?php
/**
 * NOTICE OF LICENSE
 *
 * @copyright  Copyright (c) 30.04.2020 brainstation GbR
 * @author     Mike Becker<mike@brainstation.de>
 */
declare(strict_types=1);

namespace BstDiscountBadge6\Storefront\Subscriber;

use BstDiscountBadge6\Struct\ConfigData;
use Psr\Log\LoggerInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityLoadedEvent;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Pagelet\Header\HeaderPageletLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Frontend implements EventSubscriberInterface
{
    /**
     * @var SystemConfigService
     */
    private $systemConfigService;

    /** @var LoggerInterface */
    private $logger;

    /**
     * Frontend constructor.
     * @param SystemConfigService $systemConfigService
     * @param LoggerInterface $logger
     */
    public function __construct(SystemConfigService $systemConfigService, LoggerInterface $logger)
    {
        $this->systemConfigService = $systemConfigService;
        $this->logger = $logger;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            HeaderPageletLoadedEvent::class => 'onPageLoaded'
        ];
    }

    /**
     * @param HeaderPageletLoadedEvent $event
     */
    public function onPageLoaded(HeaderPageletLoadedEvent $event): void
    {
        $config = new ConfigData($this->systemConfigService, $event->getSalesChannelContext());
        $event->getPagelet()->addExtension('BstDiscountBadge6', $config);
    }
}