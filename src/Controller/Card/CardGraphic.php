<?php

namespace App\Card;

class CardGraphic extends Card
{
    private $representation = [];
    private $suits = [
        '♠',
        '♡',
        '♢',
        '♣',
    ];

    private $ranks = [
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
        'K'
    ];

    // foreach ($this->$suits of $suit) {
    //     foreach ($this->$ranks of $rank) {
    //         $this->$representation[] = $rank - $suit;
    //     }
    // }

    public function __construct()
    {
        parent::__construct();
    }

    public function getAsString(): string
    {
        return $this->representation[$this->value - 1];
    }
}