<?php

namespace App\Controller;

use App\Service\MovieDatabaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private MovieDatabaseService $movieService;

    public function __construct(MovieDatabaseService $movieService)
    {
        $this->movieService = $movieService;
    }

    #[Route('/', name: 'home')]
    public function upcomingMovies(Request $request): Response
    {
        $page = $request->query->get('page', 1);
        $params = [
            'year' => '2023'
        ];
        $data = $this->movieService->apiRequest('GET', 'https://moviesdatabase.p.rapidapi.com/titles', $params, $page);

        return $this->render('home/index.html.twig', [
            'data' => $data,
            'currentPage' => $page,
        ]);
    }
}
