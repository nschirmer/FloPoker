<?php
namespace PlayingCardBundle\Tests\Util;

use PlayingCardBundle\Util\Card;
use PHPUnit\Framework\TestCase;
use PlayingCardBundle\Util\CardInterface;
use PlayingCardBundle\Util\HandInterface;

class CardTest extends TestCase
{
    public function testConstructor()
    {
        $card = new Card('Diamond', '5');

        $this->assertInstanceOf(CardInterface::class, $card);
        $this->assertEquals('Diamond', $card->getSuit());
        $this->assertEquals('5', $card->getRank());
    }

    public function testSetters()
    {
        $card = new Card;
        $card->setSuit('Heart');
        $card->setRank('Jack');

        $this->assertEquals('Heart', $card->getSuit());
        $this->assertEquals('Jack', $card->getRank());
    }

    public function testHandSetter()
    {
        $card = new Card;
        $hand = $this->createMock(HandInterface::class);

        $card->setHand($hand);

        $this->assertEquals($hand, $card->getHand());
    }

    public function testGetName()
    {
        $card = new Card('Heart', 'Queen');

        $this->assertEquals('Queen of Hearts', $card->getName());
        $this->assertSame($card->getName(), (string) $card);
    }
}