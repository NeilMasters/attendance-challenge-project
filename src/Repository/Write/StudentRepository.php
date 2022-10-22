<?php
declare(strict_types=1);

namespace Attendance\Repository\Write;

use Attendance\Entity\SaveableInterface;
use Attendance\Entity\Student;
use Attendance\Exception\Student\StudentNotFoundByMatriculationNumber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class StudentRepository extends ServiceEntityRepository implements StudentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    public function save(SaveableInterface $saveable): void
    {
        $this->getEntityManager()->persist($saveable);
        $this->getEntityManager()->flush();
    }

    public function getByMatriculationNumber(string $matriculationNumber): Student
    {
        $student = $this->findOneBy([
            'matriculationNumber' => $matriculationNumber,
        ]);

        if ($student instanceof Student) {
            return $student;
        }

        throw new StudentNotFoundByMatriculationNumber($matriculationNumber);
    }
}
