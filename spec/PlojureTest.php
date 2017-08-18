<?php

use PHPUnit\Framework\TestCase;
use Plojure\Plojure;

class PlojureTest extends TestCase
{
    public function testGet()
    {
        $instance = Plojure::get();
        $this->assertInstanceOf(Plojure::class, $instance);
    }
}
?>
