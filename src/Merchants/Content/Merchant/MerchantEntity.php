<?php declare(strict_types=1);

namespace Shopware\Production\Merchants\Content\Merchant;

use Shopware\Core\Checkout\Order\OrderCollection;
use Shopware\Core\Checkout\Shipping\ShippingMethodCollection;
use Shopware\Core\Content\Category\CategoryEntity;
use Shopware\Core\Content\Media\MediaCollection;
use Shopware\Core\Content\Media\MediaEntity;
use Shopware\Core\Content\Product\ProductCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use Shopware\Core\System\Country\CountryEntity;
use Shopware\Core\System\SalesChannel\SalesChannelEntity;
use OpenApi\Annotations as OA;
use Shopware\Production\Merchants\Content\Service\ServiceCollection;

/**
 * @OA\Schema()
 */
class MerchantEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var bool
     * @OA\Property()
     */
    protected $active;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $activationCode;

    /**
     * @var bool
     * @OA\Property()
     */
    protected $public;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $publicCompanyName;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $publicOwner;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $publicPhoneNumber;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $publicEmail;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $publicOpeningTimes;

     /**
     * @var string|null
     * @OA\Property()
     */
    protected $whatsapp;

     /**
     * @var string|null
     * @OA\Property()
     */
    protected $facebook;

     /**
     * @var string|null
     * @OA\Property()
     */
    protected $instagram;

     /**
     * @var string|null
     * @OA\Property()
     */
    protected $twitter;

     /**
     * @var string|null
     * @OA\Property()
     */
    protected $youtube;

     /**
     * @var string|null
     * @OA\Property()
     */
    protected $longitude;

     /**
     * @var string|null
     * @OA\Property()
     */
    protected $latitude;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $radius;
  
      /**
     * @var string|null
     * @OA\Property()
     */
    protected $locationpin;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $googlemap;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $tags;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $publicDescription;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $publicWebsite;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $firstName;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $lastName;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $street;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $zip;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $city;

    /**
     * @var CountryEntity|null
     */
    protected $country;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $email;

    /**
     * @var string
     * @OA\Property()
     */
    protected $password;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $phoneNumber;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $salesChannelId;

    /**
     * @var array|null
     */
    protected $customFields;
    
    /**
     * @var SalesChannelEntity|null
     */
    protected $salesChannel;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $categoryId;

    /**
     * @var CategoryEntity|null
     */
    protected $category;

    /**
     * @var ProductCollection|null
     */
    protected $products;

    /**
     * @var ShippingMethodCollection
     */
    protected $shippingMethods;

    /**
     * @var OrderCollection
     */
    protected $orders;

    /**
     * @var MediaCollection|null
     */
    protected $media;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $coverId;



    /**
     * @var MediaEntity|null
     */
    protected $cover;



    /**
     * @var string|null
     * @OA\Property()
     */
    protected $imprint;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $tos;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $privacy;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $revocation;

    /**
     * @var int
     */
    protected $availability;

    /**
     * @var string|null
     */
    protected $availabilityText;

    /**
     * @var ServiceCollection|null
     */
    protected $services;


    /**
     * @var string|null
     * @OA\Property()
     */
    protected $mollieProdKey;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $mollieTestKey;

    /**
     * @var bool
     * @OA\Property()
     */
    protected $mollieTestEnabled;

    /**
     * @var string|null
     * @OA\Property()
     */
    protected $paymentMethods;



    public function isActive(): bool
    {
        return $this->active;
    }

    public function getActivationCode(): ?string
    {
        return $this->activationCode;
    }

    /**
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): void
    {
        $this->public = $public;
    }

    public function getPublicCompanyName(): ?string
    {
        return $this->publicCompanyName;
    }

    public function getPublicOwner(): ?string
    {
        return $this->publicOwner;
    }

    public function setPublicOwner(?string $publicOwner): void
    {
        $this->publicOwner = $publicOwner;
    }

    public function setPublicCompanyName(?string $publicCompanyName): void
    {
        $this->publicCompanyName = $publicCompanyName;
    }

    public function getPublicPhoneNumber(): ?string
    {
        return $this->publicPhoneNumber;
    }

    public function setPublicPhoneNumber(?string $publicPhoneNumber): void
    {
        $this->publicPhoneNumber = $publicPhoneNumber;
    }

    public function getPublicEmail(): ?string
    {
        return $this->publicEmail;
    }

    public function setPublicEmail(?string $publicEmail): void
    {
        $this->publicEmail = $publicEmail;
    }

    public function getPublicOpeningTimes(): ?string
    {
        return $this->publicOpeningTimes;
    }

    public function setPublicOpeningTimes(?string $publicOpeningTimes): void
    {
        $this->publicOpeningTimes = $publicOpeningTimes;
    }

    public function getwhatsapp(): ?string
    {
        return $this->whatsapp;
    }

    public function setwhatsapp(?string $whatsapp): void
    {
        $this->whatsapp = $whatsapp;
    }

    public function getfacebook(): ?string
    {
        return $this->facebook;
    }

    public function setfacebook(?string $facebook): void
    {
        $this->facebook = $facebook;
    }

    public function getinstagram(): ?string
    {
        return $this->instagram;
    }

    public function setinstagram(?string $instagram): void
    {
        $this->instagram = $instagram;
    }

    public function getyoutube(): ?string
    {
        return $this->youtube;
    }

    public function setyoutube(?string $youtube): void
    {
        $this->youtube = $youtube;
    }

    public function gettwitter(): ?string
    {
        return $this->twitter;
    }

    public function settwitter(?string $twitter): void
    {
        $this->twitter = $twitter;
    }

    public function getlongitude(): ?string
    {
        return $this->longitude;
    }

    public function setlongitude(?string $longitude): void
    {
        $this->longitude = $longitude;
    }

    public function getlatitude(): ?string
    {
        return $this->latitude;
    }

    public function setlatitude(?string $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function getradius(): ?string
    {
        return $this->radius;
    }

    public function setradius(?string $radius): void
    {
        $this->radius = $radius;
    }
  
      public function getlocationpin(): ?string
    {
        return $this->locationpin;
    }

    public function setlocationpin(?string $locationpin): void
    {
        $this->locationpin = $locationpin;
    }

    public function getgooglemap(): ?string
    {
        return $this->googlemap;
    }

    public function setgooglemap(?string $googlemap): void
    {
        $this->radius = $googlemap;
    }

    public function gettags(): ?string
    {
        return $this->tags;
    }

    public function settags(?string $tags): void
    {
        $this->radius = $tags;
    }

    public function getPublicDescription(): ?string
    {
        return $this->publicDescription;
    }

    public function setPublicDescription(?string $publicDescription): void
    {
        $this->publicDescription = $publicDescription;
    }

    public function getPublicWebsite(): ?string
    {
        return $this->publicWebsite;
    }

    public function setPublicWebsite(?string $publicWebsite): void
    {
        $this->publicWebsite = $publicWebsite;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): void
    {
        $this->street = $street;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(?string $zip): void
    {
        $this->zip = $zip;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function getCountry(): ?CountryEntity
    {
        return $this->country;
    }

    public function setCountry(?CountryEntity $country): void
    {
        $this->country = $country;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getSalesChannelId(): ?string
    {
        return $this->salesChannelId;
    }

    public function setSalesChannelId(?string $salesChannelId): void
    {
        $this->salesChannelId = $salesChannelId;
    }

    public function getSalesChannel(): ?SalesChannelEntity
    {
        return $this->salesChannel;
    }

    public function setSalesChannel(?SalesChannelEntity $salesChannel): void
    {
        $this->salesChannel = $salesChannel;
    }

    public function getCategoryId(): ?string
    {
        return $this->categoryId;
    }

    public function setCategoryId(?string $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function getCategory(): ?CategoryEntity
    {
        return $this->category;
    }

    public function setCategory(?CategoryEntity $category): void
    {
        $this->category = $category;
    }

    public function getProducts(): ?ProductCollection
    {
        return $this->products;
    }

    public function setProducts(?ProductCollection $products): void
    {
        $this->products = $products;
    }

    public function getShippingMethods(): ShippingMethodCollection
    {
        return $this->shippingMethods;
    }

    public function setShippingMethods(ShippingMethodCollection $shippingMethods): void
    {
        $this->shippingMethods = $shippingMethods;
    }

    public function getOrders(): OrderCollection
    {
        return $this->orders;
    }

    public function setOrders(OrderCollection $orders): void
    {
        $this->orders = $orders;
    }

    public function getMedia(): ?MediaCollection
    {
        return $this->media;
    }

    public function setMedia(?MediaCollection $media): void
    {
        $this->media = $media;
    }

    /**
     * @return MediaEntity|null
     */
    public function getCover(): ?MediaEntity
    {
        return $this->cover;
    }

    /**
     * @param MediaEntity|null $cover
     */
    public function setCover(?MediaEntity $cover): void
    {
        $this->cover = $cover;
    }

    public function getCoverId(): ?string
    {
        return $this->coverId;
    }

    public function setCoverId(?string $coverId): void
    {
        $this->coverId = $coverId;
    }

   
    public function getImprint(): ?string
    {
        return $this->imprint;
    }

    public function getTos(): ?string
    {
        return $this->tos;
    }

    public function getPrivacy(): ?string
    {
        return $this->privacy;
    }

    public function getRevocation(): ?string
    {
        return $this->revocation;
    }

    public function getAvailability(): int
    {
        return $this->availability;
    }

    public function getAvailabilityText(): ?string
    {
        return $this->availabilityText;
    }

    public function getServices(): ?ServiceCollection
    {
        return $this->services;
    }

    /**
     * @return string|null
     */
    public function getMollieProdKey(): ?string
    {
        return $this->mollieProdKey;
    }

    /**
     * @param string|null $mollieProdKey
     */
    public function setMollieProdKey(?string $mollieProdKey): void
    {
        $this->mollieProdKey = $mollieProdKey;
    }

    /**
     * @return string|null
     */
    public function getMollieTestKey(): ?string
    {
        return $this->mollieTestKey;
    }

    /**
     * @param string|null $mollieTestKey
     */
    public function setMollieTestKey(?string $mollieTestKey): void
    {
        $this->mollieTestKey = $mollieTestKey;
    }

    /**
     * @return bool
     */
    public function isMollieTestEnabled(): bool
    {
        return $this->mollieTestEnabled;
    }

    /**
     * @param bool $mollieTestEnabled
     */
    public function setMollieTestEnabled(bool $mollieTestEnabled): void
    {
        $this->mollieTestEnabled = $mollieTestEnabled;
    }

    public function getCustomFields(): ?array
    {
        return $this->customFields;
    }

    public function setCustomFields(?array $customFields): void
    {
        $this->customFields = $customFields;
    }

    /**
     * @return string|null
     */
    public function getPaymentMethods(): ?string
    {
        return $this->paymentMethods;
    }

    /**
     * @param string|null $paymentMethods
     */
    public function setPaymentMethods(?string $paymentMethods): void
    {
        $this->paymentMethods = $paymentMethods;
    }

    public function getParentId()
    {
        return null;
    }

}
