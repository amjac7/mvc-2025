<?php

namespace App\Controller;


use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardGameController extends AbstractController
{
    #[Route("/card", name: "card_start")]
    public function home(): Response
    {
        return $this->render('card/home.html.twig');
    }

    #[Route("/card/draw", name: "test_draw_card")]
    public function testDrawCard(): Response
    {
        $card = new Card();

        $data = [
            "card" => $card->draw(),
            "cardString" => $card->getAsString(),
        ];

        return $this->render('card/test/draw.html.twig', $data);
    }

    #[Route("/card/draw/{num<\d+>}", name: "test_draw_num_cards")]
    public function testDrawCards(int $num): Response
    {
        if ($num > 99) {
            throw new \Exception("Can not roll more than 99 dices!");
        }

        $cardRoll = [];
        for ($i = 1; $i <= $num; $i++) {
            //$die = new Dice();
            //ändrar så använder DiceGraphic ist.
            //(nu kan man köra grafisk tärning ist).
            $card = new CardGraphic();
            $card->draw();
            $cardDraw[] = $card->getAsString();
        }

        $data = [
            "num_cards" => count($cardDraw),
            "cardDraw" => $cardDraw,
        ];

        return $this->render('card/test/draw_many.html.twig', $data);
    }


    #[Route("/card/test/dicehand/{num<\d+>}", name: "test_cardhand")]
    public function testCardHand(int $num): Response
    {
        if ($num > 99) {
            throw new \Exception("Can not roll more than 99 dices!");
        }

        $hand = new CardHand();
        for ($i = 1; $i <= $num; $i++) {
            if ($i % 2 === 1) {
                $hand->add(new CardGraphic());
            } else {
                $hand->add(new Card());
            }
        }

        $hand->draw();

        $data = [
            "num_cards" => $hand->getNumberCards(),
            "cardDraw" => $hand->getString(),
        ];

        return $this->render('card/test/cardhand.html.twig', $data);
    }


    #[Route("/card/init", name: "card_init_get", methods: ['GET'])]
    public function init(): Response
    {
        return $this->render('card/init.html.twig');
    } 

    
    #[Route("/card/init", name: "card_init_post", methods: ['POST'])]
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response
    {
        $numCard = $request->request->get('num_cards');

        $session->set("card_cards", $numCard);

        $hand = new CardHand();
        for ($i = 1; $i <= $numCard; $i++) {
            $hand->add(new CardGraphic());
        }
        $hand->draw();

        $session->set("card_cardhand", $hand);
        $session->set("card_cards", $numCard);
        $session->set("card_round", 0);
        $session->set("card_total", 0);

        return $this->redirectToRoute('card_play');
    }
    

/* DEN GAMLA KODEN OVAN ÄR NYA! */
    // #[Route("/card/init", name: "card_init_post", methods: ['POST'])]
    // public function initCallback(): Response
    // {
    //     // Deal with the submitted form

    //     return $this->redirectToRoute('card_play');
    // }

    /* GAMLA KODEN NEDAN! */
    // #[Route("/card/play", name: "card_play", methods: ['GET'])]
    // public function play(): Response
    // {
    //     // Logic to play the game

    //     return $this->render('card/play.html.twig');
    // }

    #[Route("/card/play", name: "card_play", methods: ['GET'])]
    public function play(
        SessionInterface $session
    ): Response
    {
        $cardhand = $session->get("card_cardhand");

        if (!$cardhand) {
            return $this->redirectToRoute('card_init_get');
        }

        $data = [
            "cardCards" => $session->get("card_cards"),
            "cardRound" => $session->get("card_round"),
            "cardTotal" => $session->get("card_total"),
            "cardValues" => $cardhand->getString() 
        ];

        return $this->render('card/play.html.twig', $data);
    }

    #[Route("/card/draw", name: "card_draw", methods: ['POST'])]
    public function draw(
        SessionInterface $session
    ): Response
    {
        $hand = $session->get("card_cardhand");
        $hand->draw();

        $roundTotal = $session->get("card_round");
        $round = 0;
        $values = $hand->getValues();
        foreach ($values as $value) {
            if ($value === 1) {
                $this->addFlash(
                    'warning',
                    'You got a 1 and you lost the round points!'
                );
                $round = 0;
                $roundTotal = 0;
                break;
            }
            $round += $value;
        }

        $session->set("card_round", $roundTotal + $round);
        
        return $this->redirectToRoute('card_play');
    }

    #[Route("/card/save", name: "card_save", methods: ['POST'])]
    public function save(
        SessionInterface $session
    ): Response
    {
        $roundTotal = $session->get("card_round");
        $gameTotal = $session->get("card_total");

        $session->set("card_round", 0);
        $session->set("card_total", $roundTotal + $gameTotal);

        $this->addFlash(
            'notice',
            'Your round was saved to the total!'
        );

        return $this->redirectToRoute('card_play');
    }
    
}