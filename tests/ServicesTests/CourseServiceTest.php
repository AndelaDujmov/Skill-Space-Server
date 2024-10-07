<?php

use App\Entity\Course;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CourseServiceTest extends KernelTestCase {

    private $courseRepository;
    
    public function testGetAllCourses(): void
    {
        self::bootKernel();

        $expected = [
            ['id' => '84b62734-5e78-48b4-98af-0d47aaff224e', 'name' => 'C#', 'total_points' => 21, 'lectures_points' => 3],
            ['id' => '20d2f5f7-0549-481c-a2e2-a0183929a56c', 'name' => 'DevOps', 'total_points' => 11, 'lectures_points' => 3]
        ];

        $this->courseRepository = $this->createMock(CourseRepository ::class);
        $this->courseRepository->method('fetchCourses')
                               ->willReturn($expected);

        $service = new CourseService($this->courseRepository);

        $courses = $service->getAll();

        $this->assertEquals($expected, $courses);
    }

    public function testGetCourseById(): void {
        self::bootKernel();

        $expected = $this->createMock(Course::class);

        $this->courseRepository = $this->createMock(CourseRepository::class);
        $this->courseRepository->method('fetchCourseById')
                               ->with('84b62734-5e78-48b4-98af-0d47aaff224e')
                               ->willReturn($expected);

        $service = new CourseService($this->courseRepository);
        
        $course = $service->fetchById('84b62734-5e78-48b4-98af-0d47aaff224e');

        $this->assertEquals($expected, $course);
    }

    public function testCreateCourse(): void {
        self::bootKernel();

        $course = $this->generateCourse();

        $this->courseRepository = $this->createMock(CourseRepository::class);
        $this->courseRepository->expects($this->once())
                               ->method('createCourse')
                               ->with($course);
        
        $service = new CourseService($this->courseRepository);
        $service->create($course->getName(), $course->getTotalPoints(), lecturesNumber: $course->getLecturesPoints());
    }

    public function testEditCourse(): void {
        self::bootKernel();

        $course = $this->generateCourse();

        $this->courseRepository = $this->createMock(CourseRepository::class);
        $this->courseRepository->expects($this->once())
                               ->method('updateCourse')
                               ->with('84b62734-5e78-48b4-98af-0d47aaff224e', $course);

        $service = new CourseService($this->courseRepository);
        $service->update('84b62734-5e78-48b4-98af-0d47aaff224e', $course->getName(), $course->getTotalPoints(), $course->getLecturesPoints());
    }

    private function generateCourse(): Course {
        $course = new Course();

        $course->setName('C#');
        $course->setTotalPoints(120);
        $course->setLecturesPoints(20);

        return $course;
    }

}