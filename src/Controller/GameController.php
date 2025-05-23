<?php

namespace App\Controller;
// RENSA
use App\Card\DeckofCards;
use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameController extends AbstractController
{
    #[Route("/session", name: "session_start")]
    public function sessionHome(
        SessionInterface $session
    ): Response {

        $sessionData = $session->all();


        $data = [
            "sessionData" => $sessionData
        ];

        return $this->render('card/session-home.html.twig', $data);
    }

    #[Route("/session/remove", name: "session_end")]
    public function sessionRemove(
        SessionInterface $session
    ): Response {


        $session->clear();

        $this->addFlash(
            'notice',
            'Nu är sessionen raderad!'
        );

        return $this->redirectToRoute('session_start');
    }


    //FÖR KMOM03
    #[Route("/game", name: "game_start")]
    public function gameHome(): Response
    {
        return $this->render('game/home.html.twig');
    }



    #[Route("/game/play", name: "test_play_game")]
    public function gamePlay(
        Request $request,
        // SessionInterface $session
    ): Response {


        return $this->render('game/test/play.html.twig');
    }



}
