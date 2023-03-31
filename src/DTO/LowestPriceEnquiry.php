<?php

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class LowestPriceEnquiry
{
    private ?int $quantity = 1;
    private ?string $requestLocation;
    private ?string $voucherCode;
    private ?string $requestDate;
    private ?float $price;
    private ?float $discountedPrice;
    private ?int $promotionId;
    private ?string $promotionName;


    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int|null $quantity
     * @return LowestPriceEnquiry
     */
    public function setQuantity(?int $quantity): LowestPriceEnquiry
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRequestLocation(): ?string
    {
        return $this->requestLocation;
    }

    /**
     * @param string|null $requestLocation
     * @return LowestPriceEnquiry
     */
    public function setRequestLocation(?string $requestLocation): LowestPriceEnquiry
    {
        $this->requestLocation = $requestLocation;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVoucherCode(): ?string
    {
        return $this->voucherCode;
    }

    /**
     * @param string|null $voucherCode
     * @return LowestPriceEnquiry
     */
    public function setVoucherCode(?string $voucherCode): LowestPriceEnquiry
    {
        $this->voucherCode = $voucherCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRequestDate(): ?string
    {
        return $this->requestDate;
    }

    /**
     * @param string|null $requestDate
     * @return LowestPriceEnquiry
     */
    public function setRequestDate(?string $requestDate): LowestPriceEnquiry
    {
        $this->requestDate = $requestDate;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     * @return LowestPriceEnquiry
     */
    public function setPrice(?float $price): LowestPriceEnquiry
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getDiscountedPrice(): ?float
    {
        return $this->discountedPrice;
    }

    /**
     * @param float|null $discountedPrice
     * @return LowestPriceEnquiry
     */
    public function setDiscountedPrice(?float $discountedPrice): LowestPriceEnquiry
    {
        $this->discountedPrice = $discountedPrice;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getFinalTotalPrice(): ?float
    {
        return $this->finalTotalPrice;
    }

    /**
     * @param float|null $finalTotalPrice
     * @return LowestPriceEnquiry
     */
    public function setFinalTotalPrice(?float $finalTotalPrice): LowestPriceEnquiry
    {
        $this->finalTotalPrice = $finalTotalPrice;
        return $this;
    }
    private ?float $finalTotalPrice;

    /**
     * @return int|null
     */
    public function getPromotionId(): ?int
    {
        return $this->promotionId;
    }

    /**
     * @param int|null $promotionId
     * @return LowestPriceEnquiry
     */
    public function setPromotionId(?int $promotionId): LowestPriceEnquiry
    {
        $this->promotionId = $promotionId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPromotionName(): ?string
    {
        return $this->promotionName;
    }

    /**
     * @param string|null $promotionName
     * @return LowestPriceEnquiry
     */
    public function setPromotionName(?string $promotionName): LowestPriceEnquiry
    {
        $this->promotionName = $promotionName;
        return $this;
    }



}
