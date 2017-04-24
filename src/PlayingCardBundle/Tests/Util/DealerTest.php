<?php
namespace PlayingCardBundle\Tests\Util;

use PHPUnit\Framework\TestCase;
use PlayingCardBundle\Exception\DealException;
use PlayingCardBundle\Service\CardGenerator;
use PlayingCardBundle\Service\ScoringServiceInterface;
use PlayingCardBundle\Util\CardInterface;
use PlayingCardBundle\Util\Dealer;
use PlayingCardBundle\Util\DealerInterface;
use PlayingCardBundle\Util\Deck;
use PlayingCardBundle\Util\HandInterface;

class DealerTest extends TestCase
{
    private $cardGenerator;
    private $deck;

    public function setUp()
    {
        $this->cardGenerator = new CardGenerator;
        $this->deck = new Deck($this->cardGenerator);
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(DealerInterface::class, new Dealer);
    }

    public function testScoringServiceSetter()
    {
        $dealer = new Dealer;
        $scoringService = $this->createMock(ScoringServiceInterface::class);

        $dealer->setScoringService($scoringService);

        $this->assertSame($scoringService, $dealer->getScoringService());
    }

    public function testDeck()
    {
        $dealer = new Dealer;
        $dealer->setDeck($this->deck);

        $this->assertSame($this->deck, $dealer->getDeck());
    }

    public function testDrawCard()
    {
        $dealer = new Dealer;
        $dealer->setDeck($this->deck);

        $card = $dealer->drawCard();
        $this->assertInstanceOf(CardInterface::class, $card);
        $this->assertSame($dealer->getDeck()->getCards()[0], $card);
    }

    public function testRemainingCards()
    {
        $dealer = new Dealer;
        $dealer->setDeck($this->deck);

        $cards = $dealer->getDeck()->getCards();
        array_shift($cards);

        $dealer->drawCard();

        $this->assertSame($cards, $dealer->getRemainingCards());
        $this->assertEquals(51, $dealer->numCardsInDeck());
    }

    public function testDealCards()
    {
        $dealer = new Dealer;
        $dealer->setDeck($this->deck);

        $hand1 = $this->createMock(HandInterface::class);
        $hand2 = $this->createMock(HandInterface::class);

        $dealer->deal(3, $hand1, $hand2);
        $nextCard = $dealer->drawCard();

        $this->assertSame($dealer->getDeck()->getCards()[6], $nextCard);
        $this->assertEquals(45, $dealer->numCardsInDeck());
    }

    public function testDealAllCards()
    {
        $dealer = new Dealer;
        $dealer->setDeck($this->deck);

        $hand1 = $this->createMock(HandInterface::class);
        $hand2 = $this->createMock(HandInterface::class);

        $dealer->deal(26, $hand1, $hand2);
        $this->assertEquals(0, $dealer->numCardsInDeck());
    }

    public function testDealTooManyCards()
    {
        $this->expectException(DealException::class);
        $dealer = new Dealer;
        $dealer->setDeck($this->deck);

        $hand1 = $this->createMock(HandInterface::class);
        $hand2 = $this->createMock(HandInterface::class);

        $dealer->deal(27, $hand1, $hand2);
    } // @codeCoverageIgnore

    public function testShuffleCards()
    {
        $dealer = new Dealer;
        $dealer->setDeck($this->deck);

        $dealer->shuffleCards();

        // We're testing randomness here so there's a very minuscule chance that this test will fail
        $this->assertNotEquals($dealer->getDeck()->getCards(), $dealer->getRemainingCards());
    }

    public function testResetDeck()
    {
        $dealer = new Dealer;
        $dealer->setDeck($this->deck);

        $hand1 = $this->createMock(HandInterface::class);
        $dealer->deal(5, $hand1);
        $dealer->resetDeck(false);

        $this->assertEquals(52, $dealer->numCardsInDeck());
        $this->assertSame($dealer->getDeck()->getCards()[0], $dealer->drawCard());
    }

    public function testResetDeckWithShuffle()
    {
        $dealer = new Dealer;
        $dealer->setDeck($this->deck);

        $hand1 = $this->createMock(HandInterface::class);
        $dealer->deal(5, $hand1);
        $dealer->resetDeck(true);

        $this->assertEquals(52, $dealer->numCardsInDeck());
        $this->assertNotEquals($dealer->getDeck()->getCards(), $dealer->getRemainingCards());
    }

    public function testScore()
    {
        $dealer = new Dealer;
        $dealer->setDeck($this->deck);

        $testScore = 5;

        $hand1 = $this->createMock(HandInterface::class);
        $hand1->expects($this->once())
                ->method('setScore')
                ->with($this->equalTo($testScore));

        $scoringService = $this->createMock(ScoringServiceInterface::class);
        $scoringService->expects($this->once())
                        ->method('getScore')
                        ->with($this->identicalTo($hand1))
                        ->willReturn($testScore);

        $dealer->setScoringService($scoringService);

        $dealer->score($hand1);
    }
}
