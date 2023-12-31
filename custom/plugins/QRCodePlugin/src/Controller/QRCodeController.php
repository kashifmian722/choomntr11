<?php declare(strict_types=1);

namespace QRCodePlugin\Controller;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\Content\Media\File\FileSaver;
use Shopware\Core\Content\Media\File\MediaFile;
use Shopware\Core\Content\Media\File\FileNameProvider;
use Shopware\Core\Framework\Util\Random;
use Shopware\Core\Content\Seo\SeoUrlPlaceholderHandlerInterface;
use Shopware\Storefront\Framework\Routing\RequestTransformer;

require '../../vendor/autoload.php';
use PHPQRCode\Constants;
use PHPQRCode\QRcode;
use PHPQRCode\QRencode;


/**
 * @RouteScope(scopes={"storefront"})
 */
class QRCodeController extends StorefrontController
{
    /**
     * @var string
     */
    private $cacheDir;

    private $mediaUpdater;
    private $fileNameProvider;
    private $systemConfigService;
    private $productRepository;
    private $seoUrlReplacer;
    private $mediaRepository;

    public function __construct( 
        FileSaver $mediaUpdater, 
        FileNameProvider $fileNameProvider, 
        string $cacheDir, 
        EntityRepositoryInterface $productRepository,
        SeoUrlPlaceholderHandlerInterface $seoUrlReplacer,
        EntityRepositoryInterface $mediaRepository ) {
        $this->cacheDir = $cacheDir;
        $this->mediaUpdater = $mediaUpdater;
        $this->fileNameProvider = $fileNameProvider; 
        $this->productRepository = $productRepository;  
        $this->seoUrlReplacer = $seoUrlReplacer; 
        $this->mediaRepository = $mediaRepository; 

    }

    /**
     * @Route(name="frontend.qrcode.load", path="/qrcode/v{version}/index/{id}/{type}", methods={"GET"})
     */
    public function index(string $id,string $type, Request $request): JsonResponse
    {
        
        if($type == "product"){

            var_dump("Hello");
            exit();


            $product = $this->findProductByID($id,Context::createDefaultContext());
            $product_url = $this->base_url().'/'.str_replace(' ', '-', $product->getName()).'/'.$product->getProductNumber();
            
            $mediaId = $this->generateQRCode($product_url);
			
            $criteria = new Criteria([$mediaId]);

            $media = $this->mediaRepository->search($criteria, Context::createDefaultContext())->first();
            if($mediaId){
                $this->productRepository->update([
                    [
                        'id' => $id,
                        "customFields" => [
                            "QRcode" => $media->getUrl()
                        ]
                    ]
                    

                ], Context::createDefaultContext());

            }
                
           
            
        }
        else{

        }

        return new JsonResponse([
            "data" => "Successfully Generated the QRcode dsaf af d"
        ]);
            
        
        
            
    }

    //This function will generateQRCode for given link and provide media url of that qrcode.

    private function generateQRCode(string $url){
      	
        $context = Context::createDefaultContext();
        $mediaRepository = $this->container->get('media.repository');
        $mediaId = "";
        try {
          	
            
            if (!is_writable($this->cacheDir)) {
                throw new \RuntimeException(sprintf('Unable to write in the "%s" directory', $this->cacheDir));
            }
          	
            $fileName = "QRcode";
            $fileName = $fileName . Random::getInteger(100, 100000);
            $ext = ".png";
            $path = rtrim($this->cacheDir, '/') . '/'.$fileName.$ext ;
			
          	
            $file = QRcode::png($url, $path, 'L', 3, 4);
          	
          	var_dump("QR Generated 12");
      		exit();
            $mediaId = Uuid::randomHex();
            $media = [
                [
                    'id' => $mediaId,
                    'name' => $fileName,
                    'fileName' => $fileName,
                    'mimeType' => "image/png",
                    'fileExtension' => "png",
                ]
             
            ];
            $mediaId = $mediaRepository->create($media, Context::createDefaultContext())->getEvents()->getElements()[1]->getIds()[0];
            if (is_array($mediaId)) {
                $mediaId = $mediaId['mediaId'];
            }           

            $this->upload($path, $fileName, $mediaId, $context);

            unlink($path);

            
        } catch (\Exception $e) {
            $mediaId = null;
        }

        return $mediaId;
    }


    // This function upload QRcode png to Orkiya Media
    private function upload($path, $fileName, $mediaId, $context)
    {   
        return $this->mediaUpdater->persistFileToMedia(
            new MediaFile(
                realpath($path),
                "image/png",
                "png",
                filesize($path)
            ),
            $this->fileNameProvider->provide(
                $fileName,
                "png",
                $mediaId,
                $context
            ),
            $mediaId,
            $context
        );  
    }


    // This function fetch product data on ID basis.
    private function findProductByID($productId, $salesChannelContext)
    {
        $criteria = new Criteria([$productId]);
        $criteria->addAssociation('media');
        $criteria->setLimit(1);

        $entities = $this->productRepository->search(
            $criteria,
            $salesChannelContext
        )->getEntities();

        /** @var ProductEntity */
        foreach ($entities as $entity) {
            return $entity;
        }

        return false;
    }

    private function base_url(){
        $url =  sprintf(
            "%s://%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            $_SERVER['REQUEST_URI']
        );

        $url = parse_url($url, PHP_URL_SCHEME).'://'.parse_url($url, PHP_URL_HOST); 
        $base_url = trim($url, '/');

        return $base_url;
    }



    

}
