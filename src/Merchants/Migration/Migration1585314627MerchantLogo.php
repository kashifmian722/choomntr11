<?php declare(strict_types=1);

namespace Shopware\Production\Merchants\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1585314627MerchantLogo extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1585314627;
    }

    public function update(Connection $connection): void
    {
        $sql = <<<SQL
        ALTER TABLE `merchant`
            ADD `logo_id` binary(16) DEFAULT NULL,
            ADD CONSTRAINT `fk.merchant.logo_id` FOREIGN KEY (`logo_id`) REFERENCES `media` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
        ;
SQL;

        $connection->executeQuery($sql);
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}