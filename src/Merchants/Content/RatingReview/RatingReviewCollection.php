<?php declare(strict_types=1);

namespace Shopware\Production\Merchants\Content\RatingReview;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void                  add(RatingReviewEntity $entity)
 * @method void                  set(string $key, RatingReviewEntity $entity)
 * @method RatingReviewEntity[]    getIterator()
 * @method RatingReviewEntity[]    getElements()
 * @method RatingReviewEntity|null get(string $key)
 * @method RatingReviewEntity|null first()
 * @method RatingReviewEntity|null last()
 */
class RatingReviewCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return RatingReviewEntity::class;
    }
}