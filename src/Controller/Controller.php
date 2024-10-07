<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class Controller extends AbstractController
{
    #[Route('/', name: 'app_')]
    public function index(): JsonResponse
    {
        $number = random_int(1,34);
        return $this->json([
            'message' => 'Random is '. $number,
            'path' => 'src/Controller/Controller.php',
        ]);
    }

    #[Route('/onlyfirefox', name: 'app_firefox', condition: "context.getMethod() in ['GET', 'HEAD'] and request.headers.get('User-Agent') matches '/firefox/i'")]
    public function firefox(): JsonResponse
    {
        $number = random_int(1,34);
        return $this->json([
            'message' => 'Random is '. $number,
            'path' => 'src/Controller/Controller.php',
        ]);
    }

    //#[Route(path: '/route/{number}', name:'app_number', requirements: ['number' => '\d+'])] or
    #[Route(path: '/route/{number<\d+>?1}', name:'app_number')]
    public function parameterDigit(int $number) : JsonResponse 
    {
        return $this->json([
            'message' => 'Number parameter ' . $number,
            'path' => 'src/Controller/Controller.php',
        ]);
    }

    #[Route(path: '/route/{slug}', name: 'app_slug', defaults: ['message' => 'Hello'])]
    public function parameterString($slug, $message) : JsonResponse 
    {
        return $this->json([
            'message' => 'Slug parameter ' . $message,
            'path' => 'src/Controller/Controller.php',
        ]);
    }
}
