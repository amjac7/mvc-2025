<?php

namespace App\Card;

class CardGraphic extends Card
{
    // private $representation = [];

    // private static array $representation = [];
    private $representation = [];

    private $suits = [
        '♠',
        // '♡',
        '♥',
        // '♢',
        '♦',
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


    public function __construct()
    {
        parent::__construct();

        if (!$this->representation) {
            foreach ($this->suits as $suit) {
                foreach ($this->ranks as $rank) {
                    $this->representation[] = $suit . " " . $rank;
                }
            }
        }
    }




    public function getAsString(): string
    {

        return $this->representation[$this->value - 1];

    }
}