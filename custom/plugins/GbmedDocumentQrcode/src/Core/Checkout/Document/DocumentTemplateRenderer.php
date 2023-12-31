<?php declare(strict_types=1);
/**
 * gb media
 * All Rights Reserved.
 *
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 * The content of this file is proprietary and confidential.
 *
 * @category       Shopware
 * @package        Shopware_Plugins
 * @subpackage     GbmedDocumentQrcode
 * @copyright      Copyright (c) 2019, gb media
 * @license        proprietary
 * @author         Giuseppe Bottino
 * @link           http://www.gb-media.biz
 */

namespace Gbmed\DocumentQrcode\Core\Checkout\Document;

use Gbmed\DocumentQrcode\Core\Framework\Struct\StructDocument;
use Gbmed\DocumentQrcode\Services\Logger;
use PHPQRCode\Constants;
use PHPQRCode\QRcode;
use PHPQRCode\QRencode;
use Shopware\Core\Checkout\Document\Event\DocumentTemplateRendererParameterEvent;
use Shopware\Core\Checkout\Order\Aggregate\OrderLineItem\OrderLineItemEntity;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Framework\Routing\Router;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DocumentTemplateRenderer implements EventSubscriberInterface
{
    /**
     * @var SystemConfigService
     */
    private $systemConfigService;
    /**
     * @var Router
     */
    private $router;
    /**
     * @var int
     */
    private $qrCodeData;
    /**
     * @var string
     */
    private $qrCodeImageWidth;
    /**
     * @var int
     */
    private $qrCodeLayout;
    /**
     * @var string
     */
    private $cacheDir;
    /**
     * @var Logger
     */
    private $logger;

    /**
     * Product constructor.
     * @param SystemConfigService $systemConfigService
     * @param Router $router
     * @param string $cacheDir
     * @param Logger $logger
     */
    public function __construct(
        SystemConfigService $systemConfigService,
        Router $router,
        string $cacheDir,
        Logger $logger
    ) {
        $this->systemConfigService = $systemConfigService;
        $this->router = $router;
        $this->cacheDir = $cacheDir;
        $this->logger = $logger;
    }

    /**
     * subscribe events
     *
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            DocumentTemplateRendererParameterEvent::class => 'DocumentTemplateRendererParameter'
        ];
    }

    /**
     * add extensions into document parameters
     *
     * @param DocumentTemplateRendererParameterEvent $event
     */
    public function DocumentTemplateRendererParameter(DocumentTemplateRendererParameterEvent $event): void
    {
        $this->setConfig();
        $params = $event->getParameters();

        if(!isset($params['order'])){
            return;
        }

        /** @var OrderEntity $order */
        $order = $params['order'];
        $lineItems = $order->getLineItems();

        /** @var OrderLineItemEntity $lineItem */
        foreach ($lineItems->getElements() as $index => $lineItem) {
            $qrCodeString = $this->qrCodeData
                ? $lineItem->getPayload()['productNumber']
                : $this->generateDetailPage($lineItem->getProductId());

            $lineItem->addExtension(
                'GbmedDocumentQrcode',
                $this->getStructDocument(
                    $qrCodeString,
                    $lineItem->getProduct()
                )
            );
        }

        $event->addExtension(
            'GbmedDocumentQrcode',
            $this->getStructDocument()
        );
    }

    /**
     * return formated structure
     *
     * @param string|null $qrCodeString
     * @param ProductEntity|null $product
     * @return StructDocument
     */
    public function getStructDocument($qrCodeString = null, ?ProductEntity $product = null): StructDocument
    {
        $struct = new StructDocument();
        $struct->setQrCodeData($this->qrCodeData)
            ->setQrCodeImageWidth($this->qrCodeImageWidth)
            ->setQrCodeLayout($this->qrCodeLayout);

        if ($qrCodeString) {
            $struct->setImage($this->draw($qrCodeString, $product));
        }

        return $struct;
    }

    /**
     * helper to generate url to product detail page
     *
     * @param $productId
     * @return string
     */
    private function generateDetailPage($productId): string
    {
        return $this->router->generate(
            'frontend.detail.page',
            [
                'productId' => $productId
            ],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }

    /**
     * helper to draw qr code
     *
     * @param $qrCodeString
     * @param ProductEntity|null $product
     * @return string|null
     */
    private function draw($qrCodeString, ?ProductEntity $product = null): ?string
    {
        try {
            if (!is_writable($this->cacheDir)) {
                throw new \RuntimeException(sprintf('Unable to write in the "%s" directory', $this->cacheDir));
            }

            $path = rtrim($this->cacheDir, '/') . '/GbmedDocumentQrcodeTmp.png';
            $enc = QRencode::factory(Constants::QR_ECLEVEL_L, 3, 4);
            $enc->encodePNGAndThrow($qrCodeString, $path, false);

            if (!is_file($path)) {
                throw new \RuntimeException('File not found: ' . $path);
            }

            $base64 = 'data:image/png;base64,' . base64_encode(file_get_contents($path));
            unlink($path);
        } catch (\Exception $e) {
            $this->logger->setProduct($product)
                ->error(
                    $e->getMessage(),
                    [
                        'text' => $qrCodeString
                    ]
                );
            $base64 = null;
        }

        return $base64;
    }

    /**
     * set plugin configurations
     */
    private function setConfig(): void
    {
        $this->qrCodeData = (int)$this->systemConfigService->get('GbmedDocumentQrcode.config.qrCodeData');
        $this->qrCodeImageWidth = $this->systemConfigService->get('GbmedDocumentQrcode.config.qrCodeImageWidth');
        $this->qrCodeLayout = (int)$this->systemConfigService->get('GbmedDocumentQrcode.config.qrCodeLayout');
    }
}
