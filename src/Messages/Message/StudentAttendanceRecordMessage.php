<?php
declare(strict_types=1);

namespace Attendance\Messages\Message;

use Symfony\Component\Validator\Constraints as Assert;

class StudentAttendanceRecordMessage
{
    public function __construct(
        #[Assert\Uuid(
            message: 'newAttendanceRecordId should be a valid UUID'
        )]
        public readonly string $newAttendanceRecordId,
        #[Assert\Length(
            min: 1,
            max: 256,
            minMessage: 'A matriculation number must be a minimum of 1 character short',
            maxMessage: 'A matriculation number must be a maximum of 256 characters long'
        )]
        public readonly string $matriculationNumber,
        public readonly bool $attended
    ) {
    }
}
