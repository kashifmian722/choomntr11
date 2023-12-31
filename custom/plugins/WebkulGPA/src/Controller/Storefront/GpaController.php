<?php declare(strict_types=1);

namespace Webkul\GPA\Controller\Storefront;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Storefront\Controller\StorefrontController;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"storefront"})
 */
class GpaController extends StorefrontController
{
    /**
     * @var SystemConfigService
     */
    protected $systemConfigService;
    
    public function __construct(
        SystemConfigService $systemConfigService
    )
    {
        $this->systemConfigService = $systemConfigService;
    }

    /**
      * @Route("/gpa/map", name="gpa.map", defaults={"csrf_protected"=false})
     */
    public function map(): JsonResponse
    {
        $googleApiKey = $this->systemConfigService->get('WebkulGpa.config.googleApiKey');
        $latitude = $this->systemConfigService->get('WebkulGpa.config.latitude');
        $longitude = $this->systemConfigService->get('WebkulGpa.config.longitude');

        return new JsonResponse([
            'googleApiKey' => $googleApiKey,
            'latitude' => $latitude,
            'longitude' => $longitude
        ]);
    }
  
  /**
  * @Route("/gpa/map", name="gpa.map", defaults={"csrf_protected"=false})
 */
public function map(): JsonResponse
{
    $googleApiKey = getenv('GOOGLE_MAPS_API_KEY') ?: $this->systemConfigService->get('WebkulGpa.config.googleApiKey');
    $latitude = $this->systemConfigService->get('WebkulGpa.config.latitude');
    $longitude = $this->systemConfigService->get('WebkulGpa.config.longitude');

    return new JsonResponse([
        'googleApiKey' => $googleApiKey,
        'latitude' => $latitude,
        'longitude' => $longitude
    ]);
}

    /**
     * @Route("/gpa/mapped/country", name="gpa.mapped.country", defaults={"csrf_protected"=false})
     */
    public function findCountry(Request $request): JsonResponse
    {   
        $data = $request->request->all();
        $countryName = $data['country'];
        $stateName = $data['state'];
        $countryRepository = $this->container->get('country.repository');
        $countryLists = $countryRepository->search(
            (new Criteria())
            ->addFilter(new EqualsFilter('name', $countryName)),
            Context::createDefaultContext()
        )->getEntities()->getElements();
        $countryId = '';
        foreach($countryLists as $countryList) {
            $countryId = $countryList->getId();
        }
        
        $countryStateId = '';
        $countryStateRepository = $this->container->get('country_state.repository');
        if ($countryId) {
            $countryStateLists = $countryStateRepository->search(
                (new Criteria())
                ->addFilter(new EqualsFilter('countryId', $countryId))
                ->addFilter(new EqualsFilter('name', $stateName)),
                Context::createDefaultContext()
            )->getElements();
            foreach($countryStateLists as $countryStateList) {
                $countryStateId = $countryStateList->getId();
            }
        }
        
        return new JsonResponse([
            'countryId' => $countryId ,
            'stateId' => $countryStateId
        ]);
    }
}