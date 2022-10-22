<?php
declare(strict_types=1);

namespace Attendance\Repository\Write;

use Attendance\Entity\AttendanceRecord;
use Attendance\Entity\SaveableInterface;
use Attendance\Exception\Attendance\NotFoundById;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AttendanceRecordRepository extends ServiceEntityRepository implements AttendanceRecordRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttendanceRecord::class);
    }

    public function save(SaveableInterface $saveable): void
    {
        $this->getEntityManager()->persist($saveable);
        $this->getEntityManager()->flush();
    }

    public function getById(string $id): AttendanceRecord
    {
        $attendanceRecord = $this->find($id);

        if ($attendanceRecord instanceof AttendanceRecord) {
            return $attendanceRecord;
        }

        throw new NotFoundById($id);
    }
}
