<?php

namespace App\Card;

class DeckofCards
// ÄNDRA  TILL DECKOFCARDS!!!!!!!!!!!!!!!
// HÄR!

{
    private array $deck = [];
    private int $remainingCards;

    public function __construct()
    {
        $suits = ['hearts', 'diamonds', 'clubs', 'spades'];
        $ranks = [
        'A',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        'J',
        'Q',
        ];

        $this->deck =  [];

        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                // $this->deck[] = new CardGraphic($suit, $rank);
                $card = new CardGraphic();
                $card->getValue(count($this->deck));
                $this->deck[] = $card;
            }
        }
    $this->remainingCards = count($this->deck);
    }




    public function drawCard(): ?CardGraphic
    {
        if ($this->remainingCards > 0) {
            $card = array_pop($this->deck);
            $this->remainingCards -= 1;
            return $card;
        }
        return null;
    }

    public function getRemainingCards(): int {
        return $this->remainingCards;
    }
    public function shuffle(): void {
        shuffle($this->deck);
    }

    public function getAllCards(): array {
        return $this->deck;
    }
    
}