<?php
namespace App\Services;

use App\Entity\Course;
use App\Repository\CourseRepository;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CourseService {

    private CourseRepository $courseRepository;
    private $serializer;

    public function __construct(CourseRepository $courseRepository) {
        $this->courseRepository = $courseRepository;
        $this->serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
    }

    public function getAll(): array
    {
        return $this->courseRepository->fetchCourses();
    }

    public function create(string $data): void 
    {
        $object = $this->deserialise($data);

        $course = new Course();

        $course->setName($object->getName());
        $course->setTotalPoints($object->getTotalPoints());
        $course->setLecturesPoints($object->getLecturesPoints());

        $this->courseRepository->createCourse($course);
    }

    public function fetchById(string $id): Course
    {
        return $this->courseRepository->fetchCourseById(Uuid::fromString($id));
    }

    public function update(string $id, string $data): void 
    {
        $object = $this->deserialise($data);
        $course = $this->fetchById($id);

        $course->setName($object->getName() ?? $course->getName());
        $course->setTotalPoints($object->getTotalPoints() ?? $course->getTotalPoints());
        $course->setLecturesPoints($object->getLecturesPoints() ?? $course->getLecturesPoints());

        $this->courseRepository->updateCourse(Uuid::fromString($id), $course);
    }

    public function delete(string $id): void
    {
        $this->courseRepository->deleteCourse(Uuid::fromString($id));
    }

    private function deserialise(string $data): Course {
        return $this->serializer->deserialize($data, Course::class, 'json');
    }

}