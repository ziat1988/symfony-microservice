<?php
declare(strict_types=1);

namespace App\Exception;
use Symfony\Component\Validator\ConstraintViolationList;

class EnquiryPriceViolationException extends \Exception
{

    public function __construct(int $code, private readonly string $type, private readonly ConstraintViolationList $errors)
    {
        parent::__construct((string)$errors, $code );
    }

    public function getViolationError(): ConstraintViolationList
    {
        return $this->errors;
    }

    public function getTypeError(): string
    {
        return $this->type;
    }

    public function toArray():array
    {
        return [
            'type'=> $this->getTypeError(),
            'violations'=>$this->getViolationsArray()
        ];
    }

    public function getViolationsArray():array
    {
        $violations = [];
        foreach ($this->getViolationError() as $violation){
            $violations[] = [
                'propertyPath' => $violation->getPropertyPath(),
                'message'=>$violation->getMessage()
            ];
        }
        return $violations;
    }
}
