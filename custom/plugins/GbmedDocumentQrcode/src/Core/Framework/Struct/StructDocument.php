<?php
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

namespace Gbmed\DocumentQrcode\Core\Framework\Struct;

use Shopware\Core\Framework\Struct\Struct as StructBase;

class StructDocument extends StructBase
{
    /** @var string|null $image */
    protected $image;

    /** @var int $qrCodeData */
    protected $qrCodeData = 0;

    /** @var String $qrCodeImageWidth */
    protected $qrCodeImageWidth = '60px';

    /** @var int $qrCodeLayout */
    protected $qrCodeLayout = 0;

    /**
     * @return string|null
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     * @return self
     */
    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return int
     */
    public function getQrCodeData(): int
    {
        return $this->qrCodeData;
    }

    /**
     * @param int $qrCodeData
     * @return self
     */
    public function setQrCodeData(int $qrCodeData): self
    {
        $this->qrCodeData = $qrCodeData;

        return $this;
    }

    /**
     * @return String|null
     */
    public function getQrCodeImageWidth():? String
    {
        return $this->qrCodeImageWidth;
    }

    /**
     * @param String|null $qrCodeImageWidth
     * @return self
     */
    public function setQrCodeImageWidth($qrCodeImageWidth): self
    {
        $this->qrCodeImageWidth = $qrCodeImageWidth;

        return $this;
    }

    /**
     * @return int
     */
    public function getQrCodeLayout(): int
    {
        return $this->qrCodeLayout;
    }

    /**
     * @param int $qrCodeLayout
     * @return self
     */
    public function setQrCodeLayout(int $qrCodeLayout): self
    {
        $this->qrCodeLayout = $qrCodeLayout;

        return $this;
    }
}
