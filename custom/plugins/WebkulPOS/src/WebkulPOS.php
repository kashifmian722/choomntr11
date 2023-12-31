<?php

namespace WebkulPOS;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Shopware\Core\Framework\Plugin\Context\UpdateContext;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class WebkulPOS extends Plugin
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
    }

    // public function getContainerPrefix(): string
    // {
    //     return 'webkul';
    // }

    public function getViewPaths(): array
    {
        return [
            '/Resources/views'
        ];
    }

    public function getConfigPath(): string
    {
        return '/Resources/config/';
    }

    public function getServicesFilePath(): string
    {
        return '/Resources/config/services.xml';
    }
    public function update(UpdateContext $context): void{
        $this->install($context);
    }

    public function install(InstallContext $context): void
    {
        $connection = $this->container->get(Connection::class);

        $connection->executeUpdate('
            CREATE TABLE IF NOT EXISTS `wkpos_outlet` (
            `id` BINARY(16) NOT NULL PRIMARY KEY,
            `name` VARCHAR(64) NOT NULL,
            `address` VARCHAR(255) NOT NULL,
            `city` VARCHAR(128) NOT NULL,
            `country_id` BINARY(16) NOT NULL,
            `zipcode` VARCHAR(50) NOT NULL,
            `created_at` DATETIME(3) NOT NULL,
            `updated_at` DATETIME(3),
            `active` TINYINT(1) UNSIGNED
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');

        $connection->executeUpdate('
        CREATE TABLE IF NOT EXISTS `wkpos_user`(
          `id` binary(16) NOT NULL,
          `outlet_id` binary(16) NOT NULL,
          `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
          `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
          `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
          `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
          `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
          `avatar_id` binary(16) DEFAULT NULL,
          `active` tinyint(1) unsigned DEFAULT NULL,
          `created_at` datetime(3) NOT NULL,
          `updated_at` datetime(3) DEFAULT NULL,
          `custom_fields` json DEFAULT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `username` (`username`),
          UNIQUE KEY `email` (`email`),
          KEY `fk.wkpos_user.outlet_id` (`outlet_id`),
          KEY `avatar_id` (`avatar_id`),
          CONSTRAINT `fk.wkpos_user.outlet_id` FOREIGN KEY (`outlet_id`) REFERENCES `wkpos_outlet` (`id`) ON DELETE RESTRICT,
          CONSTRAINT `wkpos_user_ibfk_1` FOREIGN KEY (`avatar_id`) REFERENCES `media` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');

        $connection->executeUpdate('
            CREATE TABLE IF NOT EXISTS `wkpos_product` (
            `id` BINARY(16) NOT NULL PRIMARY KEY,
            `product_id` BINARY(16) NOT NULL,
            `outlet_id` BINARY(16) NOT NULL,
            `stock` INT(11) NOT NULL,
            `created_at` datetime(3) DEFAULT NULL,
            `updated_at` datetime(3) DEFAULT NULL,
            `status` TINYINT(1) UNSIGNED DEFAULT 0,
            CONSTRAINT `wkpos_product_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
            CONSTRAINT `wkpos_product_ibfk_2` FOREIGN KEY (`outlet_id`) REFERENCES `wkpos_outlet` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');

        $connection->executeUpdate('
        CREATE TABLE IF NOT EXISTS `wkpos_barcode` (
            `id` binary(16) NOT NULL,
            `product_id` BINARY(16) NOT NULL,
            `barcode` VARCHAR(64) NULL,
            `created_at` datetime(3) NOT NULL,
            `updated_at` datetime(3) DEFAULT NULL,
            PRIMARY KEY (`id`),
            CONSTRAINT `wkpos_barcode_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');

        
        $connection->executeUpdate('
        CREATE TABLE IF NOT EXISTS `wkpos_order`(
            `id` binary(16) NOT NULL,
            `user_id` binary(16) NOT NULL,
            `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `auto_increment` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `cash_payment` double NOT NULL,
            `card_payment` double NOT NULL,
            `order_id` binary(16) NOT NULL,
            `order_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `created_at` datetime(3) NOT NULL,
            `updated_at` datetime(3) DEFAULT NULL,
            `custom_fields` json DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `auto_increment` (`auto_increment`),
            CONSTRAINT `wkpos_order_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');
        $connection->executeUpdate('
        CREATE TABLE IF NOT EXISTS `wkpos_default_customer` (
            `id` binary(16) NOT NULL,
            `outlet_id` BINARY(16) NOT NULL,
            `customer_id` BINARY(16) NOT NULL,
            `created_at` datetime(3) NOT NULL,
            `updated_at` datetime(3) DEFAULT NULL,
            PRIMARY KEY (`id`),
            CONSTRAINT `wkpos_default_customer_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');
    }

    public function uninstall(UninstallContext $context): void
    {
        parent::uninstall($context);
        if ($context->keepUserData()) {
            return;
        }
        
        $connection = $this->container->get(Connection::class);
        $connection->executeUpdate('DROP TABLE IF EXISTS `wkpos_barcode`');
        $connection->executeUpdate('DROP TABLE IF EXISTS `wkpos_product`');
        $connection->executeUpdate('DROP TABLE IF EXISTS `wkpos_order`');
        $connection->executeUpdate('DROP TABLE IF EXISTS `wkpos_user`');
        $connection->executeUpdate('DROP TABLE IF EXISTS `wkpos_outlet`');
        $connection->executeUpdate('DROP TABLE IF EXISTS `wkpos_default_customer`');
        
    }
}
