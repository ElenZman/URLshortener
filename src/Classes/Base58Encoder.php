<?php

/**
 * реализует упрощенный алгоритм кодирования Base58 
 * 
 * @method encode(string $numericId) 
 * @method map(int $number)
 * 
 * @author Zmanovskaya Elena
 */


namespace Shortener\Elena;

class Base58Encoder
{

  private string $symbols = "123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ";

  private function map(int $number): string
  {
    return $this->symbols[$number];
  }

  public function encode(string $numericId): string {

    $number = intval($numericId);
    $mapped = "";
    if ($number != 0) {
       while (floor($number) > 0) {
        $mapped .= $this->map($number % 58);
        $number = $number / 58;
      }
    return $mapped;
    } else {
      throw new \Exception ('Невозможно преобразовать строку в число.'); 
    }


  }

}
