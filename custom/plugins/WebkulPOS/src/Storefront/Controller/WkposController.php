<?php

declare(strict_types=1);

namespace WebkulPOS\Storefront\Controller;

use Shopware\Storefront\Controller\StorefrontController;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Sorting\FieldSorting;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use WebkulPOS\Core\Content\User\Service\UserService;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Uuid\Uuid;

/**
 * @RouteScope(scopes={"storefront"})
 */
class WkposController extends StorefrontController
{
    /**
     * @var UsertService
     */
    private $userService;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var EntityRepositoryInterface
     */
    private $merchantRepository;

    public function __construct(UserService $userService, Connection $connection, EntityRepositoryInterface $merchantRepository)
    {
        $this->userService = $userService;
        $this->connection = $connection;
        $this->merchantRepository = $merchantRepository;
    }

    /**
     * @Route("/storehub", name="frontend.wkpos")
     */
    public function indexAction(Request $request, SalesChannelContext $context, SystemConfigService $systemConfigService)
    {
        
        $config = [
            'heading' => $systemConfigService->get('WebkulPOS.config.heading',$context->getSalesChannel()->getId()) ?? 'Point of Sale',
            'shopName' => $systemConfigService->get('core.basicInformation.shopName'),
            'address' => $systemConfigService->get('core.basicInformation.address') ?? '',
        ];

        
        $session = new Session();

        $userId = '';
        $user = [];

        if ($session->has('userId')) {
            $userId = $session->get('userId');
        }

        $userRepository = $this->container->get('wkpos_user.repository');

        if ($userId) {

            $userEntity = $userRepository->search(
                (new Criteria())
                    ->addFilter(new EqualsFilter('id', $userId))
                    ->addFilter(new EqualsFilter('active', true)),
                Context::createDefaultContext()
            )->first();

            if ($userEntity) {
                $userMediaRepository = $this->container->get('media.repository');

                $mediaEntities = $userMediaRepository->search(
                    (new Criteria())->addSorting(new FieldSorting('id'))->addFilter(new EqualsFilter('id', $userEntity->getAvatarId())),
                    Context::createDefaultContext()
                );

                $avatarMedia = $mediaEntities->first();

                $criteria = new Criteria([$userEntity->getCustomFields()['merchantId']]);

                $profile = $this->merchantRepository->search($criteria, Context::createDefaultContext())->first();
                
                $user = [
                    'userId' => $userEntity->getId(),
                    'outletId' => $userEntity->getOutletId(),
                    'name' => $userEntity->__toString(),
                    'username' => $userEntity->getUsername(),
                    'email' => $userEntity->getEmail(),
                    'merchantId' => $userEntity->getCustomFields()['merchantId'],
                    'merchant' => $profile->getPublicCompanyName(),
                    'merchant_owner' => $profile->getPublicOwner(),
                    'address' => $profile->getStreet(),
                    'city' => $profile->getCity(),
                    'avatar' => $avatarMedia ? $avatarMedia->getUrl() : ''
                ];
            }
        }

        $hostname = getenv('APP_URL');

        if ($request->server->get('HTTPS') == 'on') {
          $hostname = str_replace('http://', 'https://', $hostname);
        }

        return $this->renderStorefront('@WebkulPOS/storefront/wkpos/index.html.twig',  [
            'hostname' => $hostname,
            'user'     => $user,
            'config' => $config
        ]);
    }

    /**
     * @Route("/wkpos/currency", name="frontend.wkpos.currency", defaults={"csrf_protected"=false})
     */
    public function loadCurrency(Request $request)
    {
        $currencies = [];
        $currencyRepository = $this->container->get('currency.repository');

        $currencyEntities = $currencyRepository->search(
            (new Criteria())->addSorting(new FieldSorting('factor')),
            Context::createDefaultContext()
        );

        $currencyEntities->getElements();

        foreach ($currencyEntities->getElements() as $key => $currency) {
            $currencies[] = [
                'id' => $currency->getId(),
                'symbol' => $currency->getSymbol(),
                'name' => $currency->getName(),
                'factor' => $currency->getFactor(),
                'isoCode' => $currency->getIsoCode(),
                'shortName' => $currency->getShortName()
            ];
        }

        return new JsonResponse($currencies);
    }

    /**
     * @Route("/wkpos/login", name="frontend.wkpos.login", defaults={"csrf_protected"=false}, methods={"POST"})
     */
    public function loginAction(Request $request, RequestDataBag $data, SalesChannelContext $context): ?Response
    {   
        $session = new Session();
        $expireAfter = 2;
        $wrongAttempt = false;
        if($session->has($request->request->all()['username'])) {
            $secondsInactive = time() - $session->get($request->request->all()['username']);
            $expireAfterSeconds = $expireAfter * 60;
            if($secondsInactive >= $expireAfterSeconds){
                $session->remove($request->request->all()['username']);
            } else {
                $wrongAttempt = true;
            }
        }

        $userEntity = false;
        $errorCount = 0;
        $error = false;
        $message = '';
        $user = [];
        if (!$wrongAttempt) {
            try {
                $userEntity = $this->userService->loginWithPassword($data, $context);
            } catch (UnauthorizedHttpException $exception) {
                $errorCount = 1;
                $error = true;
                $message = str_replace('customer', 'user', $exception->getMessage());
            }

            if ($userEntity && !$userEntity->getActive()) {
                $errorCount = 1;
                $error = true;
                $message = 'User not found';
            } else if ($userEntity) {

                $outletRepository = $this->container->get('wkpos_outlet.repository');

                $outletEntity = $outletRepository->search(
                    (new Criteria([$userEntity->getOutletId()]))
                        ->addFilter(new EqualsFilter('active', true)),
                    Context::createDefaultContext()
                );

                if ($outletEntity->getTotal() < 1) {
                    $errorCount = 1;
                    $error = true;
                    $message = 'User not found';
                } else {
                    $session = new Session();
                    $session->set('userId', $userEntity->getId());
                    $userMediaRepository = $this->container->get('media.repository');

                    $mediaEntities = $userMediaRepository->search(
                        (new Criteria())
                            ->addSorting(new FieldSorting('id'))
                            ->addFilter(new EqualsFilter('id', $userEntity->getAvatarId())),
                        Context::createDefaultContext()
                    );

                    $avatarMedia = $mediaEntities->first();

                    $user = [
                        'userId' => $userEntity->getId(),
                        'outletId' => $userEntity->getOutletId(),
                        'name' => $userEntity->__toString(),
                        'username' => $userEntity->getUsername(),
                        'email' => $userEntity->getEmail(),
                      	'merchantId' => $userEntity->getCustomFields()['merchantId'],
                        'avatar' => $avatarMedia ? $avatarMedia->getUrl() : ''
                    ];
                }
            }
        } else {
            $errorCount = 1;
            $error = true;
            $message ='';
        }

        $response = array(
            'user'  => $user,
            'error' => $error,
            'errorCount' => $errorCount,
            'message' => $message
        );

        return new JsonResponse($response);
    }

    /**
     * @Route("/wkpos/logout", name="frontend.wkpos.logout", defaults={"csrf_protected"=false})
     */
    public function logoutAction(Request $request, SalesChannelContext $context): JsonResponse
    {

        $session = new Session();

        if ($session->has('userId')) {
            $session->remove('userId');
        }

        return new JsonResponse(array(
            'message' => 'Logged Successfully!'
        ));
    }


    /**
     * @Route("/wkpos/configure", name="frontend.wkpos.configure", defaults={"csrf_protected"=false})
     */
    public function configure(Request $request, SalesChannelContext $context)
    {
        $token = $context->getToken();
        //$connection = $this->container->get(Connection::class);
        
        $payload = $this->connection->fetchAll("SELECT `payload` FROM `sales_channel_api_context` WHERE `token` = '" . $token . "'");
       
        if (count($payload) > 0) {
            $this->connection->update(
                'sales_channel_api_context',
                ['payload' => json_encode(['currencyId' => $request->request->get('currencyId')])],
                ['token' => $token]
            );
        } else {
            $this->connection->insert('sales_channel_api_context', [
                'token' => $token,
                'payload' => json_encode([
                    'currencyId' => $request->request->get('currencyId')
                ]),
            ]);
        }
       
        return new JsonResponse(['success' => true]);
    }

    /**
     * @Route("/wkpos/wrong/attempt", name="frontend.wkpos.wrong.attempt", defaults={"csrf_protected"=false})
     */
    public function wrongAttempt(Request $request) 
    {
        $session = new Session();
        $error = false;
        if ($session->has($request->request->all()['username'])) {
            $error = true;
        }
        $session->set($request->request->all()['username'], time());
        return new JsonResponse($error);
    }
    /**
     * @Route("/wkpos/barcode", name="frontend.wkpos.barcode", defaults={"csrf_protected"=false})
     */
    public function getProductBacode()
    {
        $barcodeRepository = $this->container->get('wkpos_barcode.repository');
        $barcodeData = $barcodeRepository->search((new Criteria()),Context::createDefaultContext())->getElements();
        return new JsonResponse($barcodeData);
    }
    /**
     * @Route("/wkpos/get/single/barcode", name="frontend.wkpos.get.single.barcode", defaults={"csrf_protected"=false})
     */
    public function getSingleProductBacode(Request $request)
    {
        $barcode = $request->request->get('barcode');
        $barcodeRepository = $this->container->get('wkpos_barcode.repository');
        $barcodeData = $barcodeRepository->search((new Criteria())->addFilter(new EqualsFilter('barcode',$barcode)),Context::createDefaultContext())->first();
        $productId = null;
        if($barcodeData){
            $productId = $barcodeData->get('productId');
        }
       
        return new JsonResponse($productId);
    }
    /**
     * @Route("/wkpos/default/customer", name="frontend.wkpos.default.customer", defaults={"csrf_protected"=false})
     */
    public function makeDefaultCustomer(Request $request,SalesChannelContext $context)
    {
        $customerId = $request->request->get('customerId');
        $outletId = $request->request->get('outletId');
        $defaultCustomerRepository = $this->container->get('wkpos_default_customer.repository');
        $entityData = $defaultCustomerRepository->search((new Criteria())->addFilter(new EqualsFilter('outletId',$outletId)),$context->getContext())->first();
        if ($entityData) {
            $id = $entityData->getId();
        } else {
            $id = Uuid::randomHex();
        }
        $defaultCustomerRepository->upsert([['id'=>$id,'customerId'=>$customerId,'outletId'=>$outletId]],$context->getContext());
        return new JsonResponse(['success'=>true,'id'=>$id]);

    }
}
