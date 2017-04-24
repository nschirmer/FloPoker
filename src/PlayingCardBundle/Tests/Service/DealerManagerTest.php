<?php
namespace PlayingCardBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use PlayingCardBundle\Service\DealerManager;
use PlayingCardBundle\Service\DealerManagerInterface;
use PlayingCardBundle\Service\ScoringServiceInterface;
use PlayingCardBundle\Util\Dealer;
use PlayingCardBundle\Util\DeckInterface;

class DealerManagerTest extends TestCase
{
    public function testConstructor()
    {
        $this->assertInstanceOf(DealerManagerInterface::class, new DealerManager);
    }

    public function testGetDealer()
    {
        $dealerManager = new DealerManager;
        $scoringService = $this->createMock(ScoringServiceInterface::class);
        $deck = $this->createMock(DeckInterface::class);

        $dealer = $dealerManager->getDealer($deck, $scoringService);

        $this->assertInstanceOf(Dealer::class, $dealer);
        $this->assertSame($scoringService, $dealer->getScoringService());
        $this->assertSame($deck, $dealer->getDeck());
    }
}