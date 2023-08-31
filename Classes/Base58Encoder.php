<?php

require_once('Classes\DbConnection.php');

class Base58Encoder
{

  private string $symbols = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789";

  private function map(int $number): string
  {
    return $this->symbols[$number];
  }

  public function encode(string $numericId): string
  {

    $number = intval($numericId);
    $mapped = "";
    if ($number !== 0) {
       while (floor($number) > 0) {
        $mapped .= $this->map($number % 58);
        $number = $number / 58;
      }
    }
    return $mapped;
  }

  public function decode(string $shortUrl): string
  {

    $id = 0; // initialize result 

    // A simple base conversion logic 
    for ($i = 0; $i < strlen($shortUrl); $i++) {
      if (
        'a' <= $shortUrl[$i] &&
        $shortUrl[$i] <= 'z'
      )
        $id = $id * 58 + $shortUrl[$i] - 'a';
      if (
        'A' <= $shortUrl[$i] &&
        $shortUrl[$i] <= 'Z'
      )
        $id = $id * 58 + $shortUrl[$i] - 'A' + 26;
      if (
        '0' <= $shortUrl[$i] &&
        $shortUrl[$i] <= '9'
      )
        $id = $id * 52 + $shortUrl[$i] - '0' + 52;
    }
    return $id;
  }
}
