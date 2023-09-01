<?php

/**
 * генерирует рандомное число, которое использует для кодирования,
 * осуществляет кодировку 
 * 
 * @method encode(string $numericId)
 * @method map(int $number)
 * 
 * @author Zmanovskaya Elena
 */

namespace Shortener\Elena;

class URLshortener
{
    //в последствии у нас может быть много кодировщиков,
    //реализующих единый интерфейс
    private Base58Encoder $encoder;

    public function __construct()
    {
        $this->encoder = new Base58Encoder();
    }

    public function randomizeNumericId(): string
    {
        $random = '';
        for ($id = 0; $id < 8; $id++) {
            $random .= rand(0, 9);
        }
        return $random;
    }

    public function encode(int $numericId): string
    {
        $shortURL =  $this->encoder->encode($numericId);
        return $shortURL;
    }
}
