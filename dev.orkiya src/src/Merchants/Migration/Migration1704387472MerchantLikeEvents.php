<?php declare(strict_types=1);

namespace Shopware\Production\Merchants\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1704387472MerchantLikeEvents extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1704387472;
    }

    public function update(Connection $connection): void
    {
        $connection->executeQuery('
            CREATE TABLE IF NOT EXISTS `merchant_like_event` (
                `id` BINARY(16) NOT NULL,
                `merchant_id` BINARY(16) NOT NULL,
                `customer_id` BINARY(16) NOT NULL,
                `event_type` VARCHAR(255) NOT NULL, -- \'like\' or \'dislike\'
                `created_at` DATETIME(3) NOT NULL,
                PRIMARY KEY (`id`),
                CONSTRAINT `fk.merchant_like_event.merchant_id` FOREIGN KEY (`merchant_id`)
                    REFERENCES `merchant` (`id`) ON DELETE CASCADE,
                CONSTRAINT `fk.merchant_like_event.customer_id` FOREIGN KEY (`customer_id`)
                    REFERENCES `customer` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}