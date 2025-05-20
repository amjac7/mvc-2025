<?php

namespace App\Controller;

use App\Card\DeckofCards;
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

    #[Route("/card/deck/draw/{num<\d+>?5}", name: "test_draw_num_cards")]
    public function testDrawCards(
        SessionInterface $session,
        int $num = 5
        ): Response
    {

        $deck = $session->get("deck");

        if (!$deck) {
            $deck = new DeckofCards();
        }

        if ($num > 52) {
            throw new \Exception("Can not roll more than 52 cards!");
        }

        $cardDraw = [];
        for ($i = 1; $i <= $num; $i++) {
            $card = $deck->drawCard();
            if ($card === null) {
                break;
            }
            $cardDraw[] = $card->getAsString();
        }

        $session->set("deck", $deck);

        $data = [
            "num_cards" => count($cardDraw),
            "cardDraw" => $cardDraw,
            "remainingCards" => $deck->getRemainingCards(),
        ];

        return $this->render('card/test/draw_many.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "test_draw_card")]
    public function testDrawOneCard(
        Request $request,
        SessionInterface $session
    ): Response
    {
        $deck = $session->get("deck");

        if (!$deck) {
            $deck = new DeckofCards();
        }

        $card = $deck->drawCard();

        $session->set("deck",$deck);

        $data = [
            "card" => $card,
            "cardString" => $card->getAsString() ?? "No more cards.",
            "remainingCards" => $deck->getRemainingCards(),
        ];

        return $this->render('card/test/draw.html.twig', $data);
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

    #[Route("/card/deck", name: "card_deck")]
    public function testShowFullDeck(
        SessionInterface $session
    ): Response
    {

        $deck = $session->get("deck");

        if (!$deck) {
            $deck = new DeckofCards();
        }




        $cards = $deck->getSortedCards();
        
        $cardDraw = [];

        foreach ($cards as $card) {
            $cardDraw[] = $card->getAsString();
        }

        $data = [
            "cardDraw" => $cardDraw, 
        ];

        return $this->render('card/test/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "card_deck_shuffle")]
    public function testShuffleDeck(
        SessionInterface $session
    ): Response
    {
        //code
        $deck = new DeckofCards();

        $deck->shuffle();

        $session->set("deck", $deck);

        $cards = $deck->getAllCards();


        $cardDraw = [];

        foreach ($cards as $card) {
            $cardDraw[] = $card->getAsString();
        }

        $data = [
            "cardDraw" => $cardDraw, 
        ];

        return $this->render('card/test/deckShuffle.html.twig', $data);
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
    

    #[Route("/card/deck/reset", name: "card_deck_reset")]
    public function resetTheDeck(
        SessionInterface $session
    ): Response
    {
        $deck = new DeckofCards();

        $session->set("deck", $deck);

        $this->addFlash(
            'notice',
            'The deck was reset!'
        );

        return $this->redirectToRoute('card_start');
    }

    #[Route("/session", name: "session_start")]
    public function sessionHome(
        SessionInterface $session
    ): Response
    {

        $sessionData = $session->all();


        $data = [
            "sessionData" => $sessionData
        ];

        return $this->render('card/session-home.html.twig', $data);
    }

    #[Route("/session/remove", name: "session_end")]
    public function sessionRemove(
        SessionInterface $session
    ): Response
    {


        $session->clear();
        
        $this->addFlash(
            'notice',
            'Nu är sessionen raderad!'
        );

        return $this->redirectToRoute('session_start');
    }
}

