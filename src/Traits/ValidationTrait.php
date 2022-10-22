<?php
declare(strict_types=1);

namespace Attendance\Traits;

use Attendance\Exception\Generic\ValidationViolation;
use Symfony\Component\Validator\ConstraintViolation;

trait ValidationTrait
{
    public function validate(object $model): object
    {
        $violations = $this->validator->validate($model);

        if ($violations->count() > 0) {
            $violationMessage = '';

            /**
             * @var ConstraintViolation $violation
             */
            foreach ($violations as $violation) {
                $violationMessage .= sprintf(
                    '%s: %s %s',
                    $violation->getPropertyPath(),
                    $violation->getMessage(),
                    PHP_EOL
                );
            }

            throw new ValidationViolation($violationMessage);
        }

        return $model;
    }
}
