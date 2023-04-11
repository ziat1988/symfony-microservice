<?php

namespace App\DTO;
use App\Entity\Product;
use Symfony\Component\Validator\Constraints as Assert;

class LowestPriceEnquiry
{

    private Product $product;

    #[Assert\NotBlank]
    #[Assert\Positive(message: 'The quantity can not less 1!')]
    private int $quantity = 1;
    private ?string $requestLocation;
    private ?string $voucherCode;
    private ?string $requestDate;
    private float $originalPrice;
    private ?float $discountedPrice =null;
    private float $totalOriginalPrice;
    private ?int $promotionId;
    private ?string $promotionName;

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return LowestPriceEnquiry
     */
    public function setProduct(Product $product): LowestPriceEnquiry
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return LowestPriceEnquiry
     */
    public function setQuantity(int $quantity): LowestPriceEnquiry
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
     * @return float
     */
    public function getOriginalPrice(): float
    {
        return $this->originalPrice;
    }

    /**
     * @param float $originalPrice
     * @return LowestPriceEnquiry
     */
    public function setOriginalPrice(float $originalPrice): LowestPriceEnquiry
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
     * @return float
     */
    public function getTotalOriginalPrice(): float
    {
        return $this->totalOriginalPrice;
    }

    /**
     * @param float $totalOriginalPrice
     * @return LowestPriceEnquiry
     */
    public function setTotalOriginalPrice(float $totalOriginalPrice): LowestPriceEnquiry
    {
        $this->totalOriginalPrice = $totalOriginalPrice;
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
