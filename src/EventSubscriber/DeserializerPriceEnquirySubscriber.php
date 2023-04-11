<?php

namespace App\EventSubscriber;

use App\Event\DeserializerPriceEnquiryEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Validator\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DeserializerPriceEnquirySubscriber implements EventSubscriberInterface
{

    public function __construct(private ValidatorInterface $validator)
    {

    }

    public static function getSubscribedEvents(): array
    {
        return [
            DeserializerPriceEnquiryEvent::NAME => 'validateDto',
        ];
    }

    public function validateDto(DeserializerPriceEnquiryEvent $event) :void
    {
        // call validation here
        $enquiry =  $event->getEnquiry();
        $errors = $this->validator->validate($enquiry);
        if (count($errors) > 0) {
            throw new InvalidArgumentException('validation failed');
        }

    }
}
