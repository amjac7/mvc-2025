<?php

namespace App\DeckofCards;

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

        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $this->deck[] = new CardGraphic($suit, $rank);
            }
    }
    $this->remainingCards = count($this->deck);
    }

     // public function draw(): int
    // {
    //     $this->value = random_int(1, 52);
    //     return $this->value;
    // }

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