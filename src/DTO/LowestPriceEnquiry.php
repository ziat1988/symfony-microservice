<?php

namespace App\DTO;
use App\Entity\Product;

class LowestPriceEnquiry
{

    private ?Product $product;

    private ?int $quantity = 1;
    private ?string $requestLocation;
    private ?string $voucherCode;
    private ?string $requestDate;
    private ?float $originalPrice;
    private ?float $discountedPrice =null;
    private ?int $promotionId;
    private ?string $promotionName;

    /**
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param Product|null $product
     * @return LowestPriceEnquiry
     */
    public function setProduct(?Product $product): LowestPriceEnquiry
    {
        $this->product = $product;
        return $this;
    }

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
    public function getOriginalPrice(): ?float
    {
        return $this->originalPrice;
    }

    /**
     * @param float|null $originalPrice
     * @return LowestPriceEnquiry
     */
    public function setOriginalPrice(?float $originalPrice): LowestPriceEnquiry
    {
        $this->originalPrice = $originalPrice;
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
