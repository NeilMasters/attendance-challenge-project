<?php
declare(strict_types=1);

namespace Attendance\Factory;

use Attendance\Exception\Generic\InvalidRequestBody;
use Attendance\Exception\Generic\RequestIsMissingParameter;
use Attendance\Messages\Message\StudentAttendanceRecordMessage;
use Attendance\Repository\Write\StudentRepositoryInterface;
use Attendance\Traits\ValidationTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class StudentAttendanceRecordFactory implements StudentAttendanceRecordFactoryInterface
{
    use ValidationTrait;

    public function __construct(
        private ValidatorInterface $validator,
        private StudentRepositoryInterface $studentRepository
    ) {
    }

    public function createFromRequest(Request $request): StudentAttendanceRecordMessage
    {
        $requestBody = json_decode((string)$request->getContent());

        if (!$requestBody instanceof \stdClass) {
            throw new InvalidRequestBody();
        }

        if (property_exists($requestBody, 'matriculationNumber') === false) {
            throw new RequestIsMissingParameter(
                'matriculation number'
            );
        }

        $student = $this->studentRepository
            ->getByMatriculationNumber($requestBody->matriculationNumber);

        $message = new StudentAttendanceRecordMessage(
            newAttendanceRecordId: (string)Uuid::v4(),
            matriculationNumber: $student->matriculationNumber,
            attended: (bool)$request->request->get('attended')
        );

        $this->validate($message);

        return $message;
    }
}
