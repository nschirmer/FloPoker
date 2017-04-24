<?php
namespace AppBundle\Service;

use AppBundle\Entity\Card;

/**
 * Class CardGenerator
 * @package AppBundle\Service
 */
class CardGenerator extends \PlayingCardBundle\Service\CardGenerator
{
    /**
     * @return string
     */
    public function getCardInterface(): string
    {
        return Card::class;
    }
}
