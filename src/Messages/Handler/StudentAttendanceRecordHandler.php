<?php
declare(strict_types=1);

namespace Attendance\Messages\Handler;

use Attendance\Entity\AttendanceRecord;
use Attendance\Messages\Message\StudentAttendanceRecordMessage;
use Attendance\Repository\Write\AttendanceRecordRepositoryInterface;
use Attendance\Repository\Write\StudentRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class StudentAttendanceRecordHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly StudentRepositoryInterface $studentRepository,
        private readonly AttendanceRecordRepositoryInterface $attendanceRecordRepository
    ) {
    }

    public function __invoke(StudentAttendanceRecordMessage $message): void
    {
        $student = $this->studentRepository->getByMatriculationNumber(
            matriculationNumber: $message->matriculationNumber
        );

        $this->attendanceRecordRepository->save(
            new AttendanceRecord(
                id: $message->newAttendanceRecordId,
                createdAt: new \DateTime(),
                student: $student,
                attended: $message->attended
            )
        );
    }
}
