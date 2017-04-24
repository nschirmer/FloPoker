<?php
namespace PlayingCardBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use PlayingCardBundle\Service\CardGeneratorInterface;
use PlayingCardBundle\Service\DeckBuilderInterface;
use PlayingCardBundle\Service\DeckBuilder;
use PlayingCardBundle\Util\CardInterface;
use PlayingCardBundle\Util\DeckInterface;

class DeckBuilderTest extends TestCase
{
    public function testConstructor()
    {
        $this->assertInstanceOf(DeckBuilderInterface::class, new DeckBuilder);
    }

    public function testCardGeneratorSetter()
    {
        $deckBuilder = new DeckBuilder;
        $cardGenerator = $this->createMock(CardGeneratorInterface::class);

        $deckBuilder->setCardGenerator($cardGenerator);

        $this->assertSame($cardGenerator, $deckBuilder->getCardGenerator());
    }

    public function testGetDeck()
    {
        $deckBuilder = new DeckBuilder;
        $cardGenerator = $this->createMock(CardGeneratorInterface::class);
        $cardMock = $this->createMock(CardInterface::class);

        $cardGenerator->method('createCard')
                        ->willReturn($cardMock);
        $deckBuilder->setCardGenerator($cardGenerator);

        $this->assertInstanceOf(DeckInterface::class, $deckBuilder->getDeck());
    }
}