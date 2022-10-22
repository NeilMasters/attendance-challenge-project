<?php
declare(strict_types=1);

namespace Attendance\Exception\Generic;

use Attendance\Exception\BadRequest;

class ValidationViolation extends BadRequest
{
    public function __construct(string $error)
    {
        parent::__construct(
            message: $error
        );
    }
}
