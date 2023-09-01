<?php 
declare(strict_types=1);

namespace tests\Unit;

use Exception;
use PHPUnit\Framework\TestCase;
use Shortener\Elena\Base58Encoder;
require_once('C:\OpenServer\domains\URLshortener\src\Classes\Base58Encoder.php');

class Base58EncoderTest extends TestCase {

    /**
    * @expectedException Exception
    */

    /** @test */
    public function throws_exception_1 () {
      
        $this->expectException(Exception::class);
        $encoder = new Base58Encoder();
        $encoder->encode('269736');
        
    }

    /** @test */
    public function throws_exception_2() {
      
        $this->expectException(Exception::class);
        $encoder = new Base58Encoder();
        $encoder->encode('S_$269736');
        
    }

}