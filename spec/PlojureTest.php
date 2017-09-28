<?php

use PHPUnit\Framework\TestCase;
use Plojure\Plojure;
use function Plojure\partial as partial;

class PlojureTest extends TestCase
{
    public function testGet()
    {
      $instance = Plojure::get();
      $this->assertInstanceOf(Plojure::class, $instance);
    }

    public function testCurryWithPassingAllArguments()
    {
      $expectedValue = 15;
      $plujure = Plojure::get();
      $fnToBeCurried = function($a, $b) {
        return $a + $b;
      };

      $curriedFunction = $plujure->curry($fnToBeCurried);
      $returnValue = $curriedFunction(10, 5);
      $this->assertEquals($expectedValue, $returnValue);
    }

    public function testCurryWithPassingPartialArguments()
    {
      $expectedValue = 15;
      $plujure = Plojure::get();
      $fnToBeCurried = function($a, $b) {
        return $a + $b;
      };

      $curriedFunction = $plujure->curry($fnToBeCurried);
      $returnValue = $curriedFunction(10);
      $returnValueFinal = $returnValue(5);
      $this->assertInstanceOf(Closure::class, $returnValue);
      $this->assertEquals($expectedValue, $returnValueFinal);
    }

    public function testCurryWithThreeArgumentsCallOneByOne()
    {
      $expectedValue = 20;
      $plujure = Plojure::get();
      $fnToBeCurried = function($a, $b, $c) {
        return $a + $b + $c;
      };

      $curriedFunction = $plujure->curry($fnToBeCurried);
      $returnFn = $curriedFunction(10);
      $returnFn = $returnFn(5);

      $this->assertEquals($expectedValue, $returnFn(5));
    }

    public function testCurryWithThreeArgumentsCallRandomly()
    {
      $expectedValue = 20;
      $plujure = Plojure::get();
      $fnToBeCurried = function($a, $b, $c) {
        return $a + $b + $c;
      };

      $curriedFunction = $plujure->curry($fnToBeCurried);
      $returnFn = $curriedFunction(10, 5);

      $this->assertEquals($expectedValue, $returnFn(5));
    }

    public function testPartial()
    {
      $fn = function($a, $b) {
        return $a * $b;
      };

      $partialFn = partial($fn, array(10));
      $this->assertEquals(100, $partialFn(10));
    }

    public function testMap()
    {
      $numbers = array(2, 4);
      $double = function($item) {
        return $item * 2;
      };

      $plujure = Plojure::get();
      $doubleMapper = $plujure->map($double);
      $this->assertEquals(0, count(array_diff(array(4, 8), $doubleMapper($numbers))));
    }

    public function testMapWithData()
    {
      $numbers = array(2, 4);
      $double = function($item) {
        return $item * 2;
      };

      $plujure = Plojure::get();
      $mappedArray = $plujure->map($double, $numbers);
      $this->assertEquals(0, count(array_diff(array(4, 8), $mappedArray)));
    }
}

?>
