<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MovieDatabaseService;

class UpcomingMoviesController extends AbstractController
{
    private MovieDatabaseService $movieService;

    public function __construct(MovieDatabaseService $movieService)
    {
        $this->movieService = $movieService;
    }

    #[Route('/upcoming/movies', name: 'app_upcoming_movies')]
    public function upcomingMovies(Request $request): Response
    {
        $page = $request->query->get('page', 1);
        $data = $this->movieService->getUpcomingMovies($page);

        return $this->render('upcoming_movies/index.html.twig', [
            'data' => $data,
            'currentPage' => $page,
        ]);
    }
}
