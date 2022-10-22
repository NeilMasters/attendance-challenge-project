<?php
declare(strict_types=1);

namespace Attendance\Exception\Generic;

use Attendance\Exception\BadRequest;

class RequestIsMissingParameter extends BadRequest
{
    public function __construct(string $parameter)
    {
        parent::__construct(
            message: sprintf('Request body is missing the parameter %s', $parameter)
        );
    }
}
