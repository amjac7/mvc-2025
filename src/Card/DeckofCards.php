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


        for ($i = 1; $i <= 52; $i++) {
            $card = new CardGraphic();
            $card->draw($i);
            $this->deck[] = $card;
        }

    $this->remainingCards = count($this->deck);
    }




    public function drawCard(): ?CardGraphic
    {
        if ($this->remainingCards > 0) {
            $card = array_pop($this->deck);
            $this->remainingCards = count($this->deck);
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

    public function getSortedCards(): array
    {
        $copy = $this->deck;

        usort($copy, function ($a, $b) {
            // return strcmp($a->getAsString(), $b->getAsString());
            return $a->getValue() <=> $b->getValue();
        });

        return $copy;
    }
    
}