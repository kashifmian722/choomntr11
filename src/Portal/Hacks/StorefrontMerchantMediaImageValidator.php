<?php declare(strict_types=1);

namespace Shopware\Production\Portal\Hacks;

use Shopware\Storefront\Framework\Media\Exception\FileTypeNotAllowedException;
use Shopware\Storefront\Framework\Media\StorefrontMediaValidatorInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class StorefrontMerchantMediaImageValidator implements StorefrontMediaValidatorInterface
{
    public function getType(): string
    {
        return 'merchant_images';
    }

    public function validate(UploadedFile $file): void
    {
        $valid = $this->checkMimeType($file, [
            'image/jpeg',
            'image/png',
            'image/gif',
        ]);

        if (!$valid) {
            throw new FileTypeNotAllowedException($file->getMimeType(), $this->getType());
        }
    }

    protected function checkMimeType(UploadedFile $file, array $allowedMimeTypes): bool
    {
        $fileMimeType = strtolower($file->getMimeType());

        foreach ($allowedMimeTypes as $mime) {
            if ($fileMimeType === strtolower($mime)) {
                return true;
            }
        }

        return false;
    }
}