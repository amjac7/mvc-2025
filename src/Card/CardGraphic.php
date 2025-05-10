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

    private $suit;
    private $rank;

    public function __construct($suit = null, $rank = null)
    {
        parent::__construct();

        $this->suit = $suit;
        $this->rank = $rank;

        // foreach ($this->suits as $suit) {
        //     foreach ($this->ranks as $rank) {
        //         $this->representation[] = $suit . " " . $rank;
        //     }
        // }

        $this->representation[] = $suit . " " . $rank;
    }

    public function getAsString(): string
    {
        // return "<div class='carddiv'>" . $this->representation[$this->value - 1] . "</div>" ;

        // return $this->representation[$this->value - 1];
        return $this->representation[$this->value];
    }
}