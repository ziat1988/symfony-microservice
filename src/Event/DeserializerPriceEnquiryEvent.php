<?php
declare(strict_types=1);

namespace App\Event;
use App\DTO\LowestPriceEnquiry;
use Symfony\Contracts\EventDispatcher\Event;

class DeserializerPriceEnquiryEvent extends Event
{

    public const NAME = 'after.deserializer';
    public function __construct(
        private readonly LowestPriceEnquiry $enquiry,

    ) {
    }

    /**
     * @return LowestPriceEnquiry
     */
    public function getEnquiry(): LowestPriceEnquiry
    {
        return $this->enquiry;
    }

}
