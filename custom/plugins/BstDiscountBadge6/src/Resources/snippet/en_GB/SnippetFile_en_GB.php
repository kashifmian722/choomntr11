<?php
/**
 * NOTICE OF LICENSE
 *
 * @copyright  Copyright (c) 30.04.2020 brainstation GbR
 * @author     Mike Becker<mike@brainstation.de>
 */
declare(strict_types=1);

namespace BstDiscountBadge6\Resources\snippet\en_GB;

use Shopware\Core\System\Snippet\Files\SnippetFileInterface;

class SnippetFile_en_GB implements SnippetFileInterface
{
    public function getName(): string
    {
        return 'storefront.en-GB';
    }

    public function getPath(): string
    {
        return __DIR__ . '/storefront.en-GB.json';
    }

    public function getIso(): string
    {
        return 'en-GB';
    }

    public function getAuthor(): string
    {
        return 'BstDiscountBadge6';
    }

    public function isBase(): bool
    {
        return false;
    }

}
