<?php

namespace App\EventSubscriber;

use App\Event\DeserializerPriceEnquiryEvent;
use App\Exception\EnquiryPriceViolationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Validator\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\Response;

class DeserializerPriceEnquirySubscriber implements EventSubscriberInterface
{

    public function __construct(private ValidatorInterface $validator)
    {

    }

    public static function getSubscribedEvents(): array
    {
        return [
            DeserializerPriceEnquiryEvent::NAME => 'validateDto',
            KernelEvents::EXCEPTION => 'logException'
        ];
    }

    public function logException(ExceptionEvent $event):void
    {
        $exception = $event->getThrowable();

        if(!$exception instanceof EnquiryPriceViolationException){
            // make other exception , other invalidation handler by default. Here we only care the comportment exception for EnquiryPrice
            return;
        }

        $response = new JsonResponse($exception->toArray(),$exception->getCode());
        $event->setResponse($response);
    }


    /**
     * @throws EnquiryPriceViolationException
     */
    public function validateDto(DeserializerPriceEnquiryEvent $event) :void
    {
        // call validation here
        $enquiry =  $event->getEnquiry();
        $errors = $this->validator->validate($enquiry);
        if (count($errors) > 0) {
            throw new EnquiryPriceViolationException(Response::HTTP_UNPROCESSABLE_ENTITY,'ConstraintViolationList', $errors);
        }
    }
}
