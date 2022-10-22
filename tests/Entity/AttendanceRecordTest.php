<?php
declare(strict_types=1);

namespace Attendance\Tests\Entity;

use Attendance\Entity\AttendanceRecord;
use Attendance\Entity\SaveableInterface;
use Attendance\Entity\Student;
use Attendance\Tests\Helpers\StudentHelper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class AttendanceRecordTest extends TestCase
{
    public function testInit(): void
    {
        $entity = new AttendanceRecord(
            id: (string)Uuid::v4(),
            createdAt: new \DateTime(),
            student: StudentHelper::getStudent(),
            attended: true
        );

        $this->assertInstanceOf(AttendanceRecord::class, $entity);
        $this->assertInstanceOf(SaveableInterface::class, $entity);
    }

    public function testGenericGetters(): void
    {
        $id = Uuid::v4();
        $created = new \DateTime();

        $entity = new AttendanceRecord(
            id: (string)$id,
            createdAt: $created,
            student: StudentHelper::getStudent(),
            attended: true
        );

        $this->assertEquals((string)$id, $entity->id);
        $this->assertEquals($created, $entity->createdAt);
        $this->assertInstanceOf(Student::class, $entity->student);
        $this->assertTrue($entity->attended);
    }

    public function testImmutability(): void
    {
        $this->expectException(\Error::class);

        $entity = new AttendanceRecord(
            id: (string)Uuid::v4(),
            createdAt: new \DateTime(),
            student: StudentHelper::getStudent(),
            attended: true
        );

        $entity->attended = false;
    }
}