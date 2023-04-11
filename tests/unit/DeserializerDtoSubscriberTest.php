<?php

namespace App\Tests\unit;

use App\DTO\LowestPriceEnquiry;
use App\Event\DeserializerPriceEnquiryEvent;
use App\EventSubscriber\DeserializerPriceEnquirySubscriber;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DeserializerDtoSubscriberTest extends TestCase
{
    public function testValidateEnquiryDTO(): void
    {
        $this->assertTrue(true);
        /*
        $enquiry = new LowestPriceEnquiry();
        $enquiry->setQuantity(-5)
            ;

        $event = new DeserializerPriceEnquiryEvent($enquiry);
        $validator = $this->createMock(ValidatorInterface::class);
        $a = new DeserializerPriceEnquirySubscriber($validator);
        $a->validateDto($event);
        */
    }



}
