<?php declare(strict_types=1);

namespace MoorlFoundation\Resources\snippet\en_GB;

use Shopware\Core\System\Snippet\Files\SnippetFileInterface;

class SnippetFile_en_GB implements SnippetFileInterface
{
    public function getName(): string
    {
        return 'en-GB';
    }

    public function getPath(): string
    {
        return __DIR__ . '/en-GB.json';
    }

    public function getIso(): string
    {
        return 'en-GB';
    }

    public function getAuthor(): string
    {
        return 'moori';
    }

    public function isBase(): bool
    {
        return true;
    }
}
