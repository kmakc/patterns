<?php
/**
 * Адаптер
 * Шаблон «Адаптер» позволяет помещать несовместимый объект
 * в обёртку, чтобы он оказался совместимым с другим классом.
 */

interface LionInterface
{
    public function roar();
}

class AfricanLion implements LionInterface
{
    public function roar()
    {
    }
}

class AsianLion implements LionInterface
{
    public function roar()
    {
    }
}

class Hunter
{
    public function hunt(LionInterface $lion)
    {
    }
}

class WildDog
{
    public function bark()
    {
    }
}

// Адаптер вокруг собаки сделает её совместимой с охотником
class WildDogAdapter implements LionInterface
{
    protected $dog;

    public function __construct(WildDog $dog)
    {
        $this->dog = $dog;
    }

    public function roar()
    {
        $this->dog->bark();
    }
}

//------------------------------------------------------

$wildDog        = new WildDog();
$wildDogAdapter = new WildDogAdapter($wildDog);

$hunter = new Hunter();
$hunter->hunt($wildDogAdapter);
