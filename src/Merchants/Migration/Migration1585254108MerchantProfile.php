<?php declare(strict_types=1);

namespace Shopware\Production\Merchants\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1585254108MerchantProfile extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1585254108;
    }

    public function update(Connection $connection): void
    {
        $sql = <<<SQL
        ALTER TABLE `merchant`
            DROP COLUMN `website`,
            DROP COLUMN `name`,
            DROP COLUMN `description`,

            ADD `public_company_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            ADD `public_phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            ADD `public_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            ADD `public_opening_times` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            ADD `public_description` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            ADD `tags` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,

            ADD `first_name` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            ADD `last_name` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            ADD `street` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            ADD `zip` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            ADD `city` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            ADD `country` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            ADD `whatsapp` TEXT DEFAULT NULL,
            ADD `locationpin` TEXT DEFAULT NULL,
            ADD `googlemap` TEXT DEFAULT NULL,
            ADD `public_website` TEXT DEFAULT NULL,


            ADD `facebook` TEXT DEFAULT NULL,
            ADD `instagram` TEXT DEFAULT NULL,
            ADD `twitter` TEXT DEFAULT NULL,
            ADD `youtube` TEXT DEFAULT NULL,
            ADD `longitude` DECIMAL(10, 8) DEFAULT NULL,
            ADD `latitude` DECIMAL(10, 8) DEFAULT NULL,
            ADD `radius` DECIMAL(10, 2) DEFAULT NULL
        ;
SQL;

        $connection->executeQuery($sql);
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
