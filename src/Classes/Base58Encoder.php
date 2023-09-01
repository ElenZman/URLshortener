<?php

/**
 * @method encode(string $numericId)
 */


namespace Shortener\Elena;

class Base58Encoder
{

  private string $symbols = "123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ";

  private function map(int $number): string
  {
    return $this->symbols[$number];
  }

  public function encode(string $numericId): string | false {

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
