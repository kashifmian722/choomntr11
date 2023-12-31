<?php 

namespace Swag\ServiceBooking\Content\Merchant\Storefront\Service;

use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;

interface MerchantCriteriaLoaderInterface
{
    public function getMerchantCriteria(Criteria $criteria): Criteria;
}


 ?>