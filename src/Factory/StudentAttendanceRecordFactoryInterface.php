<?php
declare(strict_types=1);

namespace Attendance\Factory;

use Attendance\Messages\Message\StudentAttendanceRecordMessage;
use Symfony\Component\HttpFoundation\Request;

interface StudentAttendanceRecordFactoryInterface
{
    public function createFromRequest(Request $request): StudentAttendanceRecordMessage;
}
