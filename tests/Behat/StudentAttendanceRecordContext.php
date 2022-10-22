<?php
declare(strict_types=1);

namespace Attendance\Tests\Behat;

use Attendance\Entity\Student;
use Attendance\Events\Listener\Authentication\AuthenticatedRequestListener;
use Attendance\Repository\Write\AttendanceRecordRepositoryInterface;
use Attendance\Repository\Write\StudentRepositoryInterface;
use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Uid\Uuid;

class StudentAttendanceRecordContext implements Context
{
    private Response $response;
    private string $createdRecord;

    public function __construct(
        private readonly KernelInterface $kernel,
        private readonly RouterInterface $router,
        private readonly StudentRepositoryInterface $studentRepository,
        private readonly AttendanceRecordRepositoryInterface $attendanceRecordRepository
    ) { }

    /**
     * @Given The student with matriculation number :matriculationNumber exists
     */
    public function theStudentWithMatriculationNumberExists(string $matriculationNumber): void
    {
        $this->studentRepository->save(new Student(
            id: (string)Uuid::v4(),
            matriculationNumber: $matriculationNumber,
            name: 'John Smith' // We do not care about the name... until we care about the name
        ));
    }

    /**
     * @When I submit an attendance record for a student with a matric number of :matricNumber and they :attendedOrNot attended
     * @When I submit an attendance record for a student with a matric number of :arg1 and they :arg2 attended and provide an api key of :apiKey
     */
    public function iSubmitAnAttendanceRecordForAStudentWithAMatricNumberOfAndTheyAttended2(
        string $matricNumber,
        string $attendedOrNot,
        string $apiKey = AuthenticatedRequestListener::API_KEY_OK
    ): void {
        $request = Request::create(
            uri: $this->router->generate('record_student_attendance'),
            method: Request::METHOD_POST,
            content: (string)json_encode([
                'matriculationNumber' => $matricNumber,
                'attended' => $attendedOrNot === 'have not'
            ])
        );

        $request->headers->add(['api-key' => $apiKey]);

        $this->response = $this->kernel->handle(
            request: $request
        );
    }
    /**
     * @Then The response should indicate I do not have access
     */
    public function theResponseShouldIndicateIDoNotHaveAccess(): void
    {
        $this->statusCheck(Response::HTTP_UNAUTHORIZED);
    }



    /**
     * @Then The response should indicate the student was not found
     */
    public function theResponseShouldIndicateTheStudentWasNotFound(): void
    {
        $this->statusCheck(Response::HTTP_NOT_FOUND);
    }

    /**
     * @Then The error should read :errorMessage
     */
    public function theErrorShouldRead(string $errorMessage): void
    {
        $errors = json_decode((string)$this->response->getContent())->errors;

        if ($errors !== $errorMessage) {
            throw new \Exception(sprintf(
                "Error message '%s' does not match expected '%s'",
                $errors,
                $errorMessage
            ));
        }
    }

    /**
     * @Then the response should indicate it has been created
     */
    public function theResponseShouldIndicateItHasBeenCreated(): void
    {
        $this->statusCheck(Response::HTTP_CREATED);

        $this->createdRecord = json_decode((string)$this->response->getContent())->createdRecord;
    }

    /**
     * @Then the database should have persisted the resulting attendance record
     */
    public function theDatabaseShouldHavePersistedTheResultingAttendanceRecord(): void
    {
        // Just calling the repository suffices. The repository itself throws an
        // exception in the event of a not found id.
        $this->attendanceRecordRepository->getById($this->createdRecord);
    }

    private function statusCheck(int $expected): void
    {
        if ($this->response->getStatusCode() !== $expected) {
            throw new \Exception(sprintf(
                'Status code %s was expected to be %s',
                $this->response->getStatusCode(),
                $expected
            ));
        }
    }
}