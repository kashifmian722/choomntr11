<?php declare(strict_types=1);

namespace Shopware\Production\Merchants\Content\MerchantLikes;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class MerchantLikesEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string
     */
    protected $merchantId;

    /**
     * @var string
     */
    protected $customerId;

    /**
     * @var \DateTimeInterface
     */
    protected $createdAt;

    public function getMerchantId(): string
    {
        return $this->merchantId;
    }

    public function setMerchantId(string $merchantId): void
    {
        $this->merchantId = $merchantId;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function setCustomerId(string $customerId): void
    {
        $this->customerId = $customerId;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}