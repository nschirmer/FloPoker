<?php
namespace PlayingCardBundle\Tests\Util;

use PHPUnit\Framework\TestCase;
use PlayingCardBundle\Service\CardGenerator;
use PlayingCardBundle\Util\Deck;
use PlayingCardBundle\Util\DeckInterface;

class DeckTest extends TestCase
{
    private $cardGenerator;

    public function setUp()
    {
        $this->cardGenerator = new CardGenerator;
    }

    public function testDefaultConstructor()
    {
        $deck = new Deck($this->cardGenerator);

        $this->assertInstanceOf(DeckInterface::class, $deck);
        $this->assertCount(4, $deck->getSuits());
        $this->assertCount(13, $deck->getRanks());
        $this->assertEquals(52, count($deck->getCards()));
    }

    public function testRedSuitsConstructor()
    {
        $deck = new Deck($this->cardGenerator, ['Heart', 'Diamond']);

        $this->assertEquals(['Heart', 'Diamond'], $deck->getSuits());
        $this->assertCount(13, $deck->getRanks());
        $this->assertCount(26, $deck->getCards());
    }

    public function testRedSuitsWithFaceCardsConstructor()
    {
        $deck = new Deck($this->cardGenerator, ['Heart', 'Diamond'], ['Jack', 'Queen', 'King', 'Ace']);

        $this->assertEquals(['Heart', 'Diamond'], $deck->getSuits());
        $this->assertEquals(['Jack', 'Queen', 'King', 'Ace'], $deck->getRanks());
        $this->assertCount(8, $deck->getCards());
    }
}