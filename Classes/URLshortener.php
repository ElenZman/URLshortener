<?php

require_once('Classes\DbConnection.php');

class URLshortener
{
    //в последствии у нас может быть много кодировщиков,
    //реализующих интерфейс
    private Base58Encoder $encoder;
  
    public function __construct()
    {      
        $this->encoder= new Base58Encoder();

    }

    public function randomizeNumericId(): string {
    $random = '';
        for($id=0; $id<10; $id++){
        $random.=rand(0,9);
     }
     return $random;
    }

   public function encode(int $numericId) : string {
   $shortURL=  $this->encoder->encode($numericId);
   return $shortURL;
   }

   public function decode(string $shortUrl) : int {
    $longURL = $this->encoder->decode($shortUrl);
    return $longURL;
   }
    
}
