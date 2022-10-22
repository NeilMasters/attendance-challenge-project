<?php
declare(strict_types=1);

namespace Attendance\Exception;

use Symfony\Component\HttpFoundation\Response;

class BadRequest extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct(
            message: $message,
            code: Response::HTTP_BAD_REQUEST
        );
    }
}
