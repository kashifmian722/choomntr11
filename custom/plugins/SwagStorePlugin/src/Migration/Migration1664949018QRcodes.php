<?php declare(strict_types=1);

namespace SwagStorePlugin\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1664949018QRcodes extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1664949018;
    }

    public function update(Connection $connection): void
    {
        // implement update
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
