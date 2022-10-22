<?php
declare(strict_types=1);

namespace Attendance\Exception\Attendance;

use Attendance\Exception\Attendance;
use Symfony\Component\HttpFoundation\Response;

class NotFound extends Attendance
{
    public function __construct(string $errorPrefix)
    {
        parent::__construct(
            message: sprintf('Attendance record was not found %s', $errorPrefix),
            code: Response::HTTP_NOT_FOUND
        );
    }
}
