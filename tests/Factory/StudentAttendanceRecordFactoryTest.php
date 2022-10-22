<?php
declare(strict_types=1);

namespace Attendance\Tests\Factory;

use Attendance\Entity\Student;
use Attendance\Exception\Generic\InvalidRequestBody;
use Attendance\Exception\Generic\RequestIsMissingParameter;
use Attendance\Factory\StudentAttendanceRecordFactory;
use Attendance\Repository\Write\StudentRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class StudentAttendanceRecordFactoryTest extends TestCase
{
    use ProphecyTrait;

    private StudentAttendanceRecordFactory $factory;
    private StudentRepositoryInterface | ObjectProphecy $studentRepository;
    private ValidatorInterface | ObjectProphecy $validator;

    public function setUp(): void
    {
        $this->validator = $this->prophesize(ValidatorInterface::class);
        $this->studentRepository = $this->prophesize(StudentRepositoryInterface::class);

        $this->factory = new StudentAttendanceRecordFactory(
            validator: $this->validator->reveal(),
            studentRepository: $this->studentRepository->reveal()
        );
    }

    public function testCreateFromRequestHappy(): void
    {
        $this->studentRepository->getByMatriculationNumber('1')
            ->shouldBeCalled()
            ->willReturn(new Student(
                id: 'dont-care',
                matriculationNumber: '1',
                name: 'dont-care'
            ));

        $this->validator->validate(Argument::any())
            ->shouldBeCalled()
            ->willReturn(new ConstraintViolationList());

        $this->factory->createFromRequest(Request::create(
            uri: '/',
            content: (string)json_encode([
                'matriculationNumber' => '1',
                'attended' => true,
            ])
        ));
    }

    public function testCreateFromRequestMissingMatriculationNumber(): void
    {
        $this->expectException(RequestIsMissingParameter::class);

        $this->studentRepository->getByMatriculationNumber('1')
            ->shouldNotBeCalled();

        $this->validator->validate(Argument::any())
            ->shouldNotBeCalled();

        $this->factory->createFromRequest(Request::create(
            uri: '/',
            content: (string)json_encode([
                'attended' => true,
            ])
        ));
    }

    public function testCreateFromRequestInvalidRequestBody(): void
    {
        $this->expectException(InvalidRequestBody::class);

        $this->studentRepository->getByMatriculationNumber('1')
            ->shouldNotBeCalled();

        $this->validator->validate(Argument::any())
            ->shouldNotBeCalled();

        $this->factory->createFromRequest(Request::create(
            uri: '/',
            content: ''
        ));
    }
}