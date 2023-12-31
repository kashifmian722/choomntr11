<?php declare(strict_types=1);

namespace WebkulPOS\Core\Content\User\Exception;

use Shopware\Core\Framework\ShopwareHttpException;
use Symfony\Component\HttpFoundation\Response;

class BadCredentialsException extends ShopwareHttpException
{
    public function __construct()
    {
        parent::__construct('Invalid username and/or password.');
    }

    public function getErrorCode(): string
    {
        return 'POS_USER_AUTH_BAD_CREDENTIALS';
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_UNAUTHORIZED;
    }
}
