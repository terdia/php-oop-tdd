<?php declare( strict_types=1 );


namespace App\Entity;


abstract class Entity
{
    abstract public function getId(): int;
    abstract public function toArray(): array ;
}