<?php declare(strict_types=1);

namespace Shopware\Production\Merchants\Content\MerchantLikes;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\DateTimeField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class MerchantLikesDefinition extends EntityDefinition
{
    public static function getEntityName(): string
    {
        return 'merchant_likes';
    }

    public function getCollectionClass(): string
    {
        return MerchantLikesCollection::class;
    }
  
    public static function getEntityClass(): string
    {
        return MerchantLikesEntity::class;
    }
  
    protected function defineFields(): FieldCollection 
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
            new FkField('merchant_id', 'merchantId', MerchantDefinition::class),
            new FkField('customer_id', 'customerId', CustomerDefinition::class),
            new DateTimeField('created_at', 'createdAt'),

            // Define the inverse association in the MerchantDefinition
            new ManyToOneAssociationField('merchant', 'merchant_id', MerchantDefinition::class, 'id', false),
            // Define the inverse association in the CustomerDefinition
            new ManyToOneAssociationField('customer', 'customer_id', CustomerDefinition::class, 'id', false),
        ]);
    }
}