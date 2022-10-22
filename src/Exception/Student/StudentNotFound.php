<?php
declare(strict_types=1);

namespace Attendance\Exception\Student;

use Attendance\Exception\Student;
use Symfony\Component\HttpFoundation\Response;

class StudentNotFound extends Student
{
    public function __construct(string $errorPrefix)
    {
        parent::__construct(
            message: sprintf('Student was not found %s', $errorPrefix),
            code: Response::HTTP_NOT_FOUND
        );
    }
}
