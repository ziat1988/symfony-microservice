<?php
declare(strict_types=1);

namespace App\Tests\Functional;

use App\DTO\LowestPriceEnquiry;
use App\Event\DeserializerPriceEnquiryEvent;
use App\EventSubscriber\DeserializerPriceEnquirySubscriber;
use App\Tests\ApplicationTestCase;

class EnquirySubscriberValidationTest extends ApplicationTestCase
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


    public function testEnquiryNotValidWithDate()
    {
        $enquiry = new LowestPriceEnquiry();
        $enquiry->setQuantity(5)
            ->setRequestDate('2023-11-44')
        ;

        /** @var DeserializerPriceEnquirySubscriber $serviceSubscribe */
        $serviceSubscribe = $this->container->get( DeserializerPriceEnquirySubscriber::class);
        $event = new DeserializerPriceEnquiryEvent($enquiry);

        $this->expectException(\InvalidArgumentException::class);
        $serviceSubscribe->validateDto($event);

    }



    public function testEnquiryValid()
    {
        $enquiry = new LowestPriceEnquiry();
        $enquiry->setQuantity(1)
          ->setRequestDate('2023-11-04')
        ;

        /** @var DeserializerPriceEnquirySubscriber $serviceSubscribe */
        $serviceSubscribe = $this->container->get( DeserializerPriceEnquirySubscriber::class);
        $event = new DeserializerPriceEnquiryEvent($enquiry);

        // Assert that the event was not stopped or modified
        $serviceSubscribe->validateDto($event);
        $this->assertFalse($event->isPropagationStopped());
    }

}
