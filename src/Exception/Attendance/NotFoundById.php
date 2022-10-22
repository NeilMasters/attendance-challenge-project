<?php
declare(strict_types=1);

namespace Attendance\Exception\Attendance;

final class NotFoundById extends NotFound
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('by id %s', $id));
    }
}
