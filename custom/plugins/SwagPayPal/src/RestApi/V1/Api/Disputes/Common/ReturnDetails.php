<?php declare(strict_types=1);
/*
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Swag\PayPal\RestApi\V1\Api\Disputes\Common;

use Swag\PayPal\RestApi\PayPalApiStruct;

abstract class ReturnDetails extends PayPalApiStruct
{
    /**
     * @var string
     */
    protected $returnTime;

    /**
     * @var string
     */
    protected $mode;

    /**
     * @var bool
     */
    protected $receipt;

    /**
     * @var string
     */
    protected $returnConfirmationNumber;

    /**
     * @var bool
     */
    protected $returned;

    public function getReturnTime(): string
    {
        return $this->returnTime;
    }

    public function setReturnTime(string $returnTime): void
    {
        $this->returnTime = $returnTime;
    }

    public function getMode(): string
    {
        return $this->mode;
    }

    public function setMode(string $mode): void
    {
        $this->mode = $mode;
    }

    public function isReceipt(): bool
    {
        return $this->receipt;
    }

    public function setReceipt(bool $receipt): void
    {
        $this->receipt = $receipt;
    }

    public function getReturnConfirmationNumber(): string
    {
        return $this->returnConfirmationNumber;
    }

    public function setReturnConfirmationNumber(string $returnConfirmationNumber): void
    {
        $this->returnConfirmationNumber = $returnConfirmationNumber;
    }

    public function isReturned(): bool
    {
        return $this->returned;
    }

    public function setReturned(bool $returned): void
    {
        $this->returned = $returned;
    }
}
