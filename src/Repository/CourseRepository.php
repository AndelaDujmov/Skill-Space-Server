<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Expr\Cast\Array_;
use PhpParser\Node\Expr\List_;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Course>
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    //    /**
    //     * @return Course[] Returns an array of Course objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Course
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function createCourse(Course $course): void
    {
        $this->getEntityManager()->persist($course);
        $this->getEntityManager()->flush();
    }

    public function fetchCourses(): array 
    {
        $repository = $this->getRepository();
        return $repository->findAll() ?? [];
    }

    public function fetchCourseById(Uuid $id): ?Course
    {
        $repository = $this->getRepository();
        return $repository->find($id);
    }

    public function fetchCourseBy(string $code = null, string $name = null){

    }

    public function updateCourse(Uuid $id, Course $updatedCourse): void
    {
        $repository = $this->getRepository();
        $course = $repository->find($id);
        $course->setName($updatedCourse->getName() ?? $course->getName());
        $course->setTotalPoints($updatedCourse->getTotalPoints() ?? $course->getTotalPoints());
        $course->setLecturesPoints($updatedCourse->getLecturesPoints() ?? $course->getLecturesPoints());

        $this->getEntityManager()->flush();
    }

    public function deleteCourse(Uuid $id): void
    {
        $repository = $this->getRepository();
        $course = $repository->find($id);
        $this->getEntityManager()->remove($course);
        $this->getEntityManager()->flush();
    }

    private function getRepository(): EntityRepository
    {
        return $this->getEntityManager()->getRepository(Course::class);
    }

}
