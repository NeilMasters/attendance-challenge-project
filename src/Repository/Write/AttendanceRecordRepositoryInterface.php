<?php
declare(strict_types=1);

namespace Attendance\Repository\Write;

use Attendance\Entity\AttendanceRecord;

interface AttendanceRecordRepositoryInterface extends SaveableRepositoryInterface
{
    public function getById(string $id): AttendanceRecord;
}
