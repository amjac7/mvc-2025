<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerTwig extends AbstractController
{
    #[Route("/lucky/number/twig", name: "lucky_number")]
    public function number(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'number' => $number
        ];

        return $this->render('lucky_number.html.twig', $data);
    }
    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }
    // #[Route("/home", name: "home")]
    // public function home(): Response
    // {
    //     return $this->render('home.html.twig');
    // }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }
    #[Route("/api", name: "apiHome")]
    public function apiHome(): Response
    {
        return $this->render('apiHome.html.twig');
    }
    #[Route("/api/quote", name: "quote")]
    public function quote(): Response
    {
        $quotes = [
            'I code with the help of API',
            'I code with js',
            'I code with php'
        ];
        date_default_timezone_set('Europe/Stockholm');


        $date = date("Y-m-d");

        $time = date("Y-m-d H:i:s");

        $data = [
            'quotes' => $quotes[array_rand($quotes)],
            'date' => $date,
            'timestamp' => $time
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

}
