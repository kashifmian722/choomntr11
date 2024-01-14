<?php declare(strict_types=1);

namespace Shopware\Production\Merchants\Content\Merchant\Api;

use OpenApi\Annotations as OA;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\Framework\Util\Random;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Core\PlatformRequest;
use Shopware\Production\Merchants\Content\Merchant\Exception\InvalidCredentialsException;
use Shopware\Production\Merchants\Content\Merchant\MerchantEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"merchant-api"})
 */
class LoginController
{
    /**
     * @var EntityRepositoryInterface
     */
    private $merchantRepository;
  
  	/**
     * @var EntityRepositoryInterface
     */
    private $posOutletRepository;
  
  	/**
     * @var EntityRepositoryInterface
     */
    private $posUserRepository;
  
  	/**
     * @var EntityRepositoryInterface
     */
    private $posProductRepository;
  
  	/**
     * @var EntityRepositoryInterface
     */
    private $productRepository;
  	

    public function __construct(
      	EntityRepositoryInterface $merchantRepository,
      	EntityRepositoryInterface $posOutletRepository,
      	EntityRepositoryInterface $posUserRepository,
      	EntityRepositoryInterface $posProductRepository,
      	EntityRepositoryInterface $productRepository
    	
    	)
    {
        $this->merchantRepository = $merchantRepository;
      	$this->posOutletRepository = $posOutletRepository;
      	$this->posUserRepository = $posUserRepository;
      	$this->posProductRepository = $posProductRepository;
      	$this->productRepository = $productRepository;
    }

    /**
     * @OA\Post(
     *      path="/login",
     *      description="Login as merchant",
     *      operationId="merchantLogin",
     *      tags={"Merchant"},
     *      @OA\Parameter(
     *        name="email",
     *        in="body",
     *        description="Email",
     *        @OA\Schema(type="string"),
     *      ),
     *      @OA\Parameter(
     *        name="password",
     *        in="body",
     *        description="Password",
     *        @OA\Schema(type="string"),
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Token",
     *          @OA\JsonContent(ref="#/definitions/LoginResponse")
     *     )
     * )
     * @Route(name="merchant-api.merchant.login", path="/merchant-api/v{version}/login", methods={"POST"}, defaults={"auth_required"=false})
     */
    public function login(RequestDataBag $dataBag): JsonResponse
    {
        if (!$dataBag->has('email') || !$dataBag->has('password')) {
            throw new InvalidCredentialsException('Invalid credentials');
        }

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('email', $dataBag->get('email')));
        $criteria->addFilter(new EqualsFilter('active', 1));
        $criteria->addFilter(new EqualsFilter('activationCode', null));

        /** @var MerchantEntity|null $merchant */
        $merchant = $this->merchantRepository->search($criteria, Context::createDefaultContext())->first();

        if (!$merchant) {
            throw new InvalidCredentialsException('Invalid credentials');
        }

        if (!password_verify($dataBag->get('password'), $merchant->getPassword())) {
            throw new InvalidCredentialsException('Invalid credentials');
        }
		
      	$customFields = $merchant->getCustomFields();
      	if(!isset($customFields["posOutletId"])){
          
          	$outletId = Uuid::randomHex();
            $outletParams = [
              'id'		=> $outletId,
              'name'	=> $merchant->getPublicCompanyName(),
              'address' => "Lahore",
              'city' 	=> "Lahore",
              'countryId' => "f6cb11055b9a4691bf6662d126c35138",
              'zipcode' => "54000",
              'active' => true
            ];	

            $this->posOutletRepository->create([$outletParams], Context::createDefaultContext());
          	
          	$posUser = [
                'outletId' => $outletId,
                'password' => $dataBag->get('password'),
                'email'	=> $dataBag->get('email'),
                'username' => $dataBag->get('email'),
                'firstName' => $merchant->getPublicCompanyName(),
                'lastName' => " ",
                'active' => true,
                'customFields' => [
                    "merchantId" => $merchant->getId(),
                ]
            ];

            $this->posUserRepository->create([$posUser], Context::createDefaultContext());
          
          	
          
          	$criteria = new Criteria();
            $criteria->addAssociation('merchants');
            $criteria->addFilter(new EqualsFilter('merchants.id', $merchant->getId()));
          	$products = $this->productRepository->search($criteria, Context::createDefaultContext());
          
          	foreach ($products as $key => $product) {
              
              	$posProduct = [
        	
                  'outletId' => $outletId,
                  'productId' => $product->getId(),
                  'stock' => $product->getStock()

              	];
              	
              	$this->posProductRepository->create([$posProduct], Context::createDefaultContext());

            
            }
          
          	$this->merchantRepository->update([
              [
                'id' => $merchant->getId(),
                "customFields" => [
                  "posOutletId" => $outletId,
                ]
              ]


            ], Context::createDefaultContext());
        }
      	
        $token = Random::getAlphanumericString(32);

        $this->merchantRepository->update([
            [
                'id' => $merchant->getId(),
                'accessTokens' => [
                    [
                        'token' => $token
                    ]
                ],
            ]
        ], Context::createDefaultContext());

        return new JsonResponse([
            PlatformRequest::HEADER_CONTEXT_TOKEN => $token
        ]);
    }
}
