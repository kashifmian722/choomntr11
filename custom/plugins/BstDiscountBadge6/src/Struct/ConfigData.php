<?php
/**
 * NOTICE OF LICENSE
 *
 * @copyright  Copyright (c) 30.04.2020 brainstation GbR
 * @author     Mike Becker<mike@brainstation.de>
 */
declare(strict_types=1);

namespace BstDiscountBadge6\Struct;

use Shopware\Core\Framework\Struct\Struct;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;

class ConfigData extends Struct
{
    const CONFIG_NAMESPACE = 'BstDiscountBadge6.config.';

    /**
     * @var array
     */
    protected $config = [];

    /**
     * StorefrontPageData constructor.
     * @param array $pluginConfig
     */
    public function __construct(SystemConfigService $systemConfigService, SalesChannelContext $context)
    {
        $pluginConfig = $systemConfigService->getDomain(self::CONFIG_NAMESPACE, $context->getSalesChannel()->getId(), true);

        foreach ($pluginConfig as $configKey => $value)
        {
            $key = str_replace(self::CONFIG_NAMESPACE, '', $configKey);
            $this->config[$key] = $value;
        }
    }

    /**
     * @return mixed
     */
    public function getConfig() : array
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config): void
    {
        $this->config = $config;
    }
}