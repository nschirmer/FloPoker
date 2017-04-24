<?php
namespace AppBundle\Entity;

interface PlayerInterface
{
    public function __construct(string $name = null);

    public function getId();

    public function setName(string $name): PlayerInterface;

    public function getName(): string;

    public function setCoins(int $coins): PlayerInterface;

    public function getCoins(): int;
}
