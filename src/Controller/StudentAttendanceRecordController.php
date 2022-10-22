<?php
declare(strict_types=1);

namespace Attendance\Controller;

use Attendance\Exception\Attendance;
use Attendance\Exception\BadRequest;
use Attendance\Exception\Student;
use Attendance\Factory\StudentAttendanceRecordFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class StudentAttendanceRecordController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly StudentAttendanceRecordFactoryInterface $studentAttendanceRecordFactory
    ) {
    }

    public function recordAttendance(Request $request): JsonResponse
    {
        try {
            $message = $this->studentAttendanceRecordFactory->createFromRequest(
                request: $request
            );

            $this->messageBus->dispatch(message: $message);
        } catch (BadRequest | Student | Attendance $e) {
            return new JsonResponse([
                'status' => $e->getCode(),
                'errors' => $e->getMessage(),
            ], $e->getCode());
        } catch (\Throwable $t) {
            return new JsonResponse([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'error' => $t->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse([
            'status' => Response::HTTP_CREATED,
            'createdRecord' => $message->newAttendanceRecordId,
        ], Response::HTTP_CREATED);
    }
}
