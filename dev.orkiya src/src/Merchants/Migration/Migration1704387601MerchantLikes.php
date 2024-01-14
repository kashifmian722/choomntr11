<?php declare(strict_types=1);

namespace Shopware\Production\Merchants\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1704387601MerchantLikes extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1704387601;
    }

    public function update(Connection $connection): void
    {
        $connection->executeQuery('
            CREATE TABLE IF NOT EXISTS `merchant_likes` (
                `id` BINARY(16) NOT NULL,
                `merchant_id` BINARY(16) NOT NULL,
                `customer_id` BINARY(16) NOT NULL,
                `created_at` DATETIME(3) NOT NULL,
                PRIMARY KEY (`id`),
                CONSTRAINT `fk.merchant_likes.merchant_id` FOREIGN KEY (`merchant_id`)
                    REFERENCES `merchant` (`id`) ON DELETE CASCADE,
                CONSTRAINT `fk.merchant_likes.customer_id` FOREIGN KEY (`customer_id`)
                    REFERENCES `customer` (`id`) ON DELETE CASCADE,
                UNIQUE INDEX `uniq.merchant_likes.merchant_customer` (`merchant_id`, `customer_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}