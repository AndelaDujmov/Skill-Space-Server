<?php

namespace App\Controller;

use App\Services\CourseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


class CourseController extends AbstractController
{
    private CourseService $courseService;

    public function __construct(CourseService $courseService) {
        $this->courseService = $courseService;
    }

    #[Route('/courses', name: 'app_courses', methods: ['GET', 'POST'])]
    public function courses(): JsonResponse
    {
        $courses = $this->courseService->getAll();

        $coursesElement = array_map(fn($course) => ['name' => $course->getName(), 'total' => $course->getTotalPoints()], $courses);
        
        return $this->json([
          'courses' => $coursesElement
        ]);
    }

    #[Route('/courses/create', name: 'app_courses_create', methods: ['POST'])]
    public function createCourse(Request $request): JsonResponse
    {
        $data = $request->getContent();
      
        $this->courseService->create($data);
        
        return $this->json([
          'courses' => "Created"
        ]);
    }

    #[Route('/courses/about/{id}', name: 'app_courses_about', methods: ['POST', 'GET'])]
    public function aboutCourse(string $id): JsonResponse
    {
        $course = $this->courseService->fetchById($id);
        
        return $this->json([
          'course' => ['name' => $course->getName(), 'ects' => $course->getTotalPoints(), 'lectures' => $course->getLecturesPoints()]
        ]);
    }

    #[Route('/courses/about', name: 'app_courses_about', methods: ['POST', 'GET'])]
    public function filterCourses(Request $request): JsonResponse
    {
      $
    }

    #[Route('/courses/edit/{id}', name: 'app_courses_edit', methods: ['PUT'])]
    public function editCourse(string $id, Request $request): JsonResponse
    {
        $data = $request->getContent();

        $this->courseService->update($id, $data);

        return $this->json([
          'courses' => 'Updated!'
        ]);
    }

    #[Route('/courses/delete/{id}', name: 'app_courses_delete', methods: ['DELETE', 'GET', 'POST'])]
    public function deleteCourse(string $id): JsonResponse
    {
        $this->courseService->delete($id);

        return $this->json([
          'courses' => 'Deleted!'
        ]);
    }

}
