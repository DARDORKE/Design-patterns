<?php

include_once 'AnimalInterface.php';

class Cat implements AnimalInterface
{
    public function getSoundType(): string
    {
        return 'Miaulement';
    }
}