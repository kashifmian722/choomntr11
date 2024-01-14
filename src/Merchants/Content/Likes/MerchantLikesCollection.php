<?php declare(strict_types=1);

namespace Shopware\Production\Merchants\Content\MerchantLikes;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void              add(MerchantLikesEntity $entity)
 * @method void              set(string $key, MerchantLikesEntity $entity)
 * @method MerchantLikesEntity[]    getIterator()
 * @method MerchantLikesEntity[]    getElements()
 * @method MerchantLikesEntity|null get(string $key)
 * @method MerchantLikesEntity|null first()
 * @method MerchantLikesEntity|null last()
 */
class MerchantLikesCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return MerchantLikesEntity::class;
    }
}