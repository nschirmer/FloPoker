<?php
namespace PlayingCardBundle\Util;

use PlayingCardBundle\Service\CardGeneratorInterface;

class Deck implements DeckInterface
{
    /**
     * @var array
     */
    protected $cards = [];

    /**
     * @var CardGeneratorInterface
     */
    protected $cardGenerator;

    /**
     * @var array
     */
    protected $suits = [
        'Diamond',
        'Heart',
        'Club',
        'Spade'
    ];

    /**
     * @var array
     */
    protected $ranks = [
        'Ace',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        'Jack',
        'Queen',
        'King'
    ];

    /**
     * Deck constructor.
     * @param CardGeneratorInterface $cardGenerator
     * @param array $suits
     * @param array $ranks
     */
    public function __construct(CardGeneratorInterface $cardGenerator, array $suits = [], array $ranks = [])
    {
        $this->cardGenerator = $cardGenerator;

        if (!empty($suits)) {
            $this->suits = $suits;
        }

        if (!empty($ranks)) {
            $this->ranks = $ranks;
        }

        $cards = [];

        foreach ($this->suits as $suit) {
            foreach ($this->ranks as $rank) {
                $cards[] = $this->cardGenerator->createCard($suit, $rank);
            }
        }

        $this->cards = $cards;
    }

    /**
     * @return array
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * @return array
     */
    public function getSuits(): array
    {
        return $this->suits;
    }

    /**
     * @return array
     */
    public function getRanks(): array
    {
        return $this->ranks;
    }
}
