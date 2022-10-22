<?php
declare(strict_types=1);

namespace Attendance\Exception\Generic;

use Attendance\Exception\BadRequest;

class InvalidRequestBody extends BadRequest
{
    public function __construct()
    {
        parent::__construct(
            message: 'Request body is not valid json'
        );
    }
}
