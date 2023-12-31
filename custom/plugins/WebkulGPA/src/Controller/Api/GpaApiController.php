<?php declare(strict_types=1);

namespace Webkul\GPA\Controller\Api;

use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;

/**
 * @RouteScope(scopes={"api"})
 */
class GpaApiController extends AbstractController
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
     * @Route("/api/v{version}/gpa/save/config", name="api.gpa.save.config")
     */
    public function saveConfig(Request $request): JsonResponse
    {   
        $configValues = $request->request->get('config');

        if ($configValues) {
            foreach ($configValues as $key => $configValue) {
                $this->systemConfigService->set('WebkulGpa.config.' .$key, $configValue);
            }
        }
        return new JsonResponse(true);
    }
}