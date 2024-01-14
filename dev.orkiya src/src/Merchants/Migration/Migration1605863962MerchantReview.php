<?php declare(strict_types=1);

namespace Shopware\Production\Merchants\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1605863962MerchantReview extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1605863962;
    }

    public function update(Connection $connection): void
    {
        $connection->executeQuery('
            CREATE TABLE IF NOT EXISTS `merchant_review` (
                `id` BINARY(16) NOT NULL,
                `merchant_id` BINARY(16) NOT NULL,
                `customer_id` BINARY(16) NULL,
                `content` LONGTEXT NULL,
                `points` DOUBLE NULL,
                `status` TINYINT(1) NULL DEFAULT \'0\',
                `review_image_id` BINARY(16) NULL,
                `created_at` DATETIME(3) NOT NULL,
                `updated_at` DATETIME(3) NULL,
                PRIMARY KEY (`id`),
                CONSTRAINT `fk.merchant_review.merchant_id` FOREIGN KEY (`merchant_id`) REFERENCES `merchant` (`id`) ON DELETE CASCADE,
                CONSTRAINT `fk.merchant_review.customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
                CONSTRAINT `fk.merchant_review.review_image_id` FOREIGN KEY (`review_image_id`) REFERENCES `media` (`id`) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}