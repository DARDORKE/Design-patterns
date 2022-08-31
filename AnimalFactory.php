<?php

include_once 'Horse.php';
include_once 'Cat.php';
include_once 'Dog.php';

class AnimalFactory
{
    /**
     * @param string $animalType
     * @return AnimalInterface
     * @throws Exception
     */
    public static function load(string $animalType): AnimalInterface
    {
        return match ($animalType) {
            'dog' => new Dog(),
            'cat' => new Cat(),
            'horse' => new Horse(),
            default => throw new Exception(),
        };
    }
}

$animalTypes = ['horse', 'dog', 'mice', 'cat', 'lion'];

foreach ($animalTypes as $animalType) {
    try {
        $animal = AnimalFactory::load($animalType);
        echo $animalType . " : " . $animal->getSoundType() . " <br/>";
    } catch (Exception $e) {
        echo $animalType . " : cet animal n'a pas été implémenté dans le système <br/>";
    }
}