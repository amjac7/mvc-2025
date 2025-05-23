<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Card\DeckofCards;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LuckyControllerJson
{
    #[Route('/lucky/number')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky MEGA number: '.$number.'</body></html>'
        );
    }

    #[Route("/lucky/hi")]
    public function hi(): Response
    {
        return new Response(
            '<html><body>Hi to MEGA you!</body></html>'
        );
    }



    #[Route("/api/lucky/number", name: "numbers")]
    public function jsonNumber(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'lucky-number' => $number,
            'lucky-message' => 'Hi MEGA JSON response there!',
        ];

        /*
                $response = new Response();
                $response->setContent(json_encode($data));
                $response->headers->set('Content-Type', 'application/json');

                return $response;
        */

        // return new JsonResponse($data);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck", name: "api_deck")]
    public function allCards(
        SessionInterface $session
    ): Response {
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


        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions()
            | JSON_PRETTY_PRINT
            | JSON_UNESCAPED_UNICODE

            //behövde tydligen lägga till
            // ovan |JSON_UNESCAPED_UNICODE
            // för att få symbolerna att funka i
            //json när visar dem i denna routen.

            // => och ja det löste problemet med symbolerna!
        );
        return $response;
    }

    #[Route("/api/deck/shuffle", name: "api_deck_shuffle", methods: ["POST"])]
    public function testShuffleApiDeck(
        SessionInterface $session
    ): Response {

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


        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions()
            | JSON_PRETTY_PRINT
            | JSON_UNESCAPED_UNICODE

            //behövde tydligen lägga till
            // ovan |JSON_UNESCAPED_UNICODE
            // för att få symbolerna att funka i
            //json när visar dem i denna routen.

            // => och ja det löste problemet med symbolerna!
        );
        return $response;
    }






    #[Route("/api/deck/draw", name: "api_deck_draw_one_get", methods: ["GET"])]
    public function testDrawOneCardApiGet(
        Request $request,
        SessionInterface $session,
    ): Response {


        $deck = $session->get("deck");

        if (!$deck) {
            $deck = new DeckofCards();
        }

        $card = $deck->drawCard();

        $session->set("deck", $deck);

        $data = [
            "card" => $card,
            "cardString" => $card->getAsString() ?? "No more cards.",
            "remainingCards" => $deck->getRemainingCards(),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions()
            | JSON_PRETTY_PRINT
            | JSON_UNESCAPED_UNICODE

            //behövde tydligen lägga till
            // ovan |JSON_UNESCAPED_UNICODE
            // för att få symbolerna att funka i
            //json när visar dem i denna routen.

            // => och ja det löste problemet med symbolerna!
        );
        return $response;
    }



    #[Route("/api/deck/draw", name: "api_deck_draw_one", methods: ["POST"])]
    public function testDrawOneCardApi(
        Request $request,
        SessionInterface $session,
    ): Response {


        $deck = $session->get("deck");

        if (!$deck) {
            $deck = new DeckofCards();
        }

        $card = $deck->drawCard();

        $session->set("deck", $deck);

        $data = [
            "card" => $card,
            "cardString" => $card->getAsString() ?? "No more cards.",
            "remainingCards" => $deck->getRemainingCards(),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions()
            | JSON_PRETTY_PRINT
            | JSON_UNESCAPED_UNICODE

            //behövde tydligen lägga till
            // ovan |JSON_UNESCAPED_UNICODE
            // för att få symbolerna att funka i
            //json när visar dem i denna routen.

            // => och ja det löste problemet med symbolerna!
        );
        return $response;
    }



    #[Route("/api/deck/draw/{num<\d+>?5}", name: "test_draw_num_cards_api_get", methods: ["GET"])]
    public function testPostDrawManyCardsApiGet(
        SessionInterface $session,
        int $num = 5
    ): Response {


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

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions()
            | JSON_PRETTY_PRINT
            | JSON_UNESCAPED_UNICODE

            //behövde tydligen lägga till
            // ovan |JSON_UNESCAPED_UNICODE
            // för att få symbolerna att funka i
            //json när visar dem i denna routen.

            // => och ja det löste problemet med symbolerna!
        );
        return $response;
    }



    #[Route("/api/deck/draw/{num<\d+>?5}", name: "test_draw_num_cards_api", methods: ["POST"])]
    public function testPostDrawManyCardsApi(
        SessionInterface $session,
        int $num = 5
    ): Response {


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

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions()
            | JSON_PRETTY_PRINT
            | JSON_UNESCAPED_UNICODE

            //behövde tydligen lägga till
            // ovan |JSON_UNESCAPED_UNICODE
            // för att få symbolerna att funka i
            //json när visar dem i denna routen.

            // => och ja det löste problemet med symbolerna!
        );
        return $response;
    }


}
