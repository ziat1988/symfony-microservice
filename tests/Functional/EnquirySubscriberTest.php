<?php
declare(strict_types=1);

namespace App\Tests\Functional;

use App\DTO\LowestPriceEnquiry;
use App\Event\DeserializerPriceEnquiryEvent;
use App\EventSubscriber\DeserializerPriceEnquirySubscriber;
use App\Tests\ApplicationTestCase;

class EnquirySubscriberTest extends ApplicationTestCase
{
    public function testEnquiryNotValid()
    {
        $enquiry = new LowestPriceEnquiry();
        $enquiry->setQuantity(-5)
        ;

        /** @var DeserializerPriceEnquirySubscriber $serviceSubscribe */
        $serviceSubscribe = $this->container->get( DeserializerPriceEnquirySubscriber::class);
        $event = new DeserializerPriceEnquiryEvent($enquiry);

        $this->expectException(\InvalidArgumentException::class);
        $serviceSubscribe->validateDto($event);


    }

}
