<?php
declare(strict_types=1);

namespace Attendance\Tests\Entity;

use Attendance\Entity\SaveableInterface;
use Attendance\Entity\Student;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class StudentTest extends TestCase
{
    private Student $entity;

    public function setUp(): void
    {
        $this->entity = new Student(
            id: (string)Uuid::v4(),
            matriculationNumber: '1',
            name: 'John Smith'
        );
    }

    public function testInit(): void
    {
        $this->assertInstanceOf(Student::class, $this->entity);
        $this->assertInstanceOf(SaveableInterface::class, $this->entity);
    }

    public function testGetters(): void
    {
        $id = (string)Uuid::v4();

        $entity = new Student(
            id: $id,
            matriculationNumber: '1',
            name: 'John Smith'
        );

        $this->assertEquals($id, $entity->id);
        $this->assertEquals('1', $entity->matriculationNumber);
        $this->assertEquals('John Smith', $entity->getName());
    }

    public function testUpdatingStudent(): void
    {
        $this->entity->updateStudentDetails(
            name: 'John Wilson'
        );

        $this->assertEquals('John Wilson', $this->entity->getName());
    }
}