<?php

use App\Entity\Course;
use App\Repository\CourseRepository;
use Symfony\Component\Uid\Uuid;

class CourseService {

    private $courseRepository;

    public function __construct(mixed $courseRepository) {
        $this->courseRepository = $courseRepository;
    }

    public function getAll(): array
    {
        return $this->courseRepository->fetchCourses();
    }

    public function create(string|null $name, int $totalPoints, int $lecturesNumber): void 
    {
        $course = new Course();

        $course->setName($name);
        $course->setTotalPoints($totalPoints);
        $course->setLecturesPoints($lecturesNumber);

        $this->courseRepository->createCourse($course);
    }

    public function fetchById(string $id): Course
    {
        return $this->courseRepository->fetchCourseById(Uuid::fromString($id));
    }

    public function update(string $id, string $name, int $totalPoints, int $lecturesNumber): void 
    {
        $course = new Course();

        $course->setName($name);
        $course->setTotalPoints($totalPoints);
        $course->setLecturesPoints($lecturesNumber);

        $this->courseRepository->updateCourse(Uuid::fromString($id), $course);
    }

    public function delete(string $id): void
    {
        $this->courseRepository->deleteCourse(Uuid::fromString($id));
    }

}