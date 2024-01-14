<?php declare(strict_types=1);

namespace Shopware\Production\Merchants\Content\Merchant\Api;

use OpenApi\Annotations as OA;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Sorting\FieldSorting;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Aggregation\Metric\SumAggregation;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Grouping\FieldGrouping;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\RangeFilter;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\System\StateMachine\StateMachineRegistry;
use Shopware\Core\System\StateMachine\Transition;
use Shopware\Production\Merchants\Content\Merchant\Exception\OrderAlreadyCompletedException;
use Shopware\Production\Merchants\Content\Merchant\Exception\OrderAlreadyPaidException;
use Shopware\Production\Merchants\Content\Merchant\MerchantEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"merchant-api"})
 */
class DashboardController
{
    /**
     * @var EntityRepositoryInterface
     */
    private $merchantRepository;

    /**
     * @var EntityRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var StateMachineRegistry
     */
    private $stateMachineRegistry;

    public function __construct(
        EntityRepositoryInterface $merchantRepository,
        EntityRepositoryInterface $orderRepository,
        StateMachineRegistry $stateMachineRegistry
    ) {
        $this->merchantRepository = $merchantRepository;
        $this->orderRepository = $orderRepository;
        $this->stateMachineRegistry = $stateMachineRegistry;
    }

    /**
     * @OA\Get(
     *      path="/dashboard",
     *      description="Give Turnover Details",
     *      operationId="turnOver",
     *      tags={"Merchant"}
     * )
     * @Route(name="merchant-api.dashboard.load", path="/merchant-api/v{version}/dashboard", methods={"GET"})
     */
    public function index(MerchantEntity $merchant, Request $request): JsonResponse
    {
      
      	// Last 5 Orders
		$limit = 5;
        $offset = 0;
        $criteria = new Criteria();
        $criteria->addAssociation('deliveries');
        $criteria->addAssociation('lineItems');
        $criteria->addAssociation('transactions');
      	
        $criteria->addSorting( new FieldSorting('order.orderNumber', 'DESC'));
        $criteria->setTotalCountMode(Criteria::TOTAL_COUNT_MODE_EXACT)
            ->addFilter(new EqualsFilter('merchants.id', $merchant->getId()))
          	->setLimit($limit)
            ->setOffset($offset);
		
        $last_five_orders = $this->orderRepository->search($criteria, Context::createDefaultContext());
      	
      
      	// Today's Info
      	$criteria = new Criteria();
        $criteria->addAssociation('deliveries');
        $criteria->addAssociation('lineItems');
        $criteria->addAssociation('transactions');
      	
        $criteria->addSorting( new FieldSorting('order.orderNumber', 'DESC'));
        $criteria->setTotalCountMode(Criteria::TOTAL_COUNT_MODE_EXACT)
            ->addFilter(new EqualsFilter('merchants.id', $merchant->getId()));
      	$criteria->addFilter(new EqualsFilter('order.orderDate', date("Y-m-d")));
		
        $todaysInfo = $this->orderRepository->search($criteria, Context::createDefaultContext());
      
      	// Last 7 Days Data
      	$criteria = new Criteria();
        $criteria->addAssociation('transactions');
      	
      	
      	
        $criteria->setTotalCountMode(Criteria::TOTAL_COUNT_MODE_EXACT)
            ->addFilter(new EqualsFilter('merchants.id', $merchant->getId()));
      	$criteria->addFilter(new RangeFilter('order.orderDate', [RangeFilter::LTE =>date("Y-m-d"), RangeFilter::GTE => date('Y-m-d', strtotime(date("Y-m-d"). ' - 7 days'))] ));
		
        $lastSevenDays = $this->orderRepository->search($criteria, Context::createDefaultContext());
      
      	$data = [
        	'lastOrders' => $last_five_orders->getEntities(),
          	'todaysInfo' => $todaysInfo->getEntities(),
          	'lastSevenDays' => $lastSevenDays->getEntities()
        ];
        return new JsonResponse([
            'data' => $data
        ]);
    }

    /**
     * @OA\Get(
     *      path="/orders/{orderId}",
     *      description="List detail information of an order",
     *      operationId="detailOrder",
     *      tags={"Merchant"}
     * )
     * @Route(name="merchant-api.orders.detail", path="/merchant-api/v{version}/order/{orderId}", methods={"GET"})
     */
    public function detail(MerchantEntity $merchant, string $orderId): JsonResponse
    {
        $criteria = new Criteria([$orderId]);
        $criteria->addFilter(new EqualsFilter('merchants.id', $merchant->getId()));
        $criteria->addAssociation('deliveries');
        $criteria->addAssociation('lineItems');
        $criteria->addAssociation('transactions');

        $order = $this->orderRepository->search($criteria, Context::createDefaultContext())->first();

        if (!$order) {
            throw new NotFoundHttpException(sprintf('Order with ID \'%s\' couldn\'t be found', $orderId));
        }

        return new JsonResponse($order);
    }


    /**
     * @OA\Post(
     *      path="/orders",
     *      description="Create An Order By Merchant",
     *      operationId="createOrder",
     *      tags={"Merchant"},
     *      @OA\Response(
     *          response="200",
     *          ref="#/definitions/SuccessResponse"
     *     )
     * )
     * @Route(name="merchant-api.orders.create", path="/merchant-api/v{version}/orders", methods={"POST"})
     */
    public function create(MerchantEntity $merchant, Request $request): JsonResponse
    {
        var_dump("Entered");
        exit();
        $criteria = new Criteria([$orderId]);
        $criteria->addFilter(new EqualsFilter('merchants.id', $merchant->getId()));
        $criteria->addAssociation('deliveries');
        $criteria->addAssociation('lineItems');
        $criteria->addAssociation('transactions');

        $order = $this->orderRepository->search($criteria, Context::createDefaultContext())->first();

        if (!$order) {
            throw new NotFoundHttpException(sprintf('Order with ID \'%s\' couldn\'t be found', $orderId));
        }

        return new JsonResponse($order);
    }

    /**
     * @OA\Patch(
     *      path="/order/{orderId}/pay",
     *      description="Mark order as paid",
     *      operationId="orderMarkPaid",
     *      tags={"Merchant"},
     *      @OA\Response(
     *          response="200",
     *          ref="#/definitions/SuccessResponse"
     *     )
     * )
     * @Route(name="merchant-api.orders.pay", path="/merchant-api/v{version}/order/{orderId}/pay", methods={"PATCH"})
     */
    public function pay(MerchantEntity $merchant, string $orderId): JsonResponse
    {
        $criteria = new Criteria([$orderId]);
        $criteria->addFilter(new EqualsFilter('merchants.id', $merchant->getId()));
        $criteria->addAssociation('transactions');

        /** @var OrderEntity $order */
        $order = $this->orderRepository->search($criteria, Context::createDefaultContext())->first();

        if (!$order) {
            throw new NotFoundHttpException(sprintf('Order with ID \'%s\' couldn\'t be found', $orderId));
        }

        if ($order->getTransactions()->last()->getStateMachineState()->getTechnicalName() === 'paid') {
            throw new OrderAlreadyPaidException(sprintf('Order with ID \'%s\' is already paid.', $orderId));
        }

        $this->stateMachineRegistry->transition(
            new Transition(
                'order_transaction',
                $order->getTransactions()->last()->getId(),
                'pay',
                'stateId'
            ), Context::createDefaultContext()
        );

        return new JsonResponse([
            'success' => true
        ]);
    }

    /**
     * @OA\Patch(
     *      path="/order/{orderId}/done",
     *      description="Mark order as done",
     *      operationId="orderMarkDone",
     *      tags={"Merchant"},
     *      @OA\Response(
     *          response="200",
     *          ref="#/definitions/SuccessResponse"
     *     )
     * )
     * @Route(name="merchant-api.orders.done", path="/merchant-api/v{version}/order/{orderId}/done", methods={"PATCH"})
     */
    public function done(MerchantEntity $merchant, string $orderId): JsonResponse
    {
        $criteria = new Criteria([$orderId]);
        $criteria->addFilter(new EqualsFilter('merchants.id', $merchant->getId()));

        /** @var OrderEntity $order */
        $order = $this->orderRepository->search($criteria, Context::createDefaultContext())->first();

        if (!$order) {
            throw new NotFoundHttpException(sprintf('Order with ID \'%s\' couldn\'t be found', $orderId));
        }

        if ($order->getStateMachineState()->getTechnicalName() !== 'open') {
            throw new OrderAlreadyCompletedException(sprintf('Order with ID \'%s\' is already completed.', $orderId));
        }

        $this->stateMachineRegistry->transition(
            new Transition(
                'order',
                $order->getId(),
                'process',
                'stateId'
            ), Context::createDefaultContext()
        );

        $this->stateMachineRegistry->transition(
            new Transition(
                'order',
                $order->getId(),
                'complete',
                'stateId'
            ), Context::createDefaultContext()
        );

        return new JsonResponse([
            'success' => true
        ]);
    }
}
