<?php

use PHPUnit\Framework\TestCase;
use Plojure\Plojure;
use function Plojure\partial as partial;
use const Plojure\CURRY_PLACEHOLDER;

class PlojureTest extends TestCase
{
  public function testCurryWithPassingAllArguments()
  {
    $expectedValue = 15;
    $fnToBeCurried = function($a, $b) {
      return $a + $b;
    };

    $curriedFunction = Plojure::curry($fnToBeCurried);
    $returnValue = $curriedFunction(10, 5);
    $this->assertEquals($expectedValue, $returnValue);
  }

  public function testCurryWithPassingPartialArguments()
  {
    $expectedValue = 15;
    $fnToBeCurried = function($a, $b) {
      return $a + $b;
    };

    $curriedFunction = Plojure::curry($fnToBeCurried);
    $returnValue = $curriedFunction(10);
    $returnValueFinal = $returnValue(5);
    $this->assertInstanceOf(Closure::class, $returnValue);
    $this->assertEquals($expectedValue, $returnValueFinal);
  }

  public function testCurryWithThreeArgumentsCallOneByOne()
  {
    $expectedValue = 20;
    $fnToBeCurried = function($a, $b, $c) {
      return $a + $b + $c;
    };

    $curriedFunction = Plojure::curry($fnToBeCurried);
    $returnFn = $curriedFunction(10);
    $returnFn = $returnFn(5);

    $this->assertEquals($expectedValue, $returnFn(5));
  }

  public function testCurryWithThreeArgumentsCallRandomly()
  {
    $expectedValue = 20;
    $fnToBeCurried = function($a, $b, $c) {
      return $a + $b + $c;
    };

    $curriedFunction = Plojure::curry($fnToBeCurried);
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

    $doubleMapper = Plojure::map($double);
    $this->assertEquals(0, count(array_diff(array(4, 8), $doubleMapper($numbers))));
  }

  public function testMapWithData()
  {
    $numbers = array(2, 4);
    $double = function($item) {
      return $item * 2;
    };

    $mappedArray = Plojure::map($double, $numbers);
    $this->assertEquals(0, count(array_diff(array(4, 8), $mappedArray)));
  }

  public function testFilter()
  {
    $numbers = array(2, 4);
    $isEqualTwo = function($item) {
      return $item === 2;
    };

    $filteredNumbers = Plojure::filter($isEqualTwo);
    $this->assertEquals(0, count(array_diff(array(2), $filteredNumbers($numbers))));
  }

  public function testReduce()
  {
    $numbers = array(1, 2, 3, 4, 5);
    $sum = function($acc, $current) {
      return $acc + $current;
    };

    $sumNumbers = Plojure::reduce($sum, 0);
    $this->assertEquals(15, $sumNumbers($numbers));
  }

  public function testPlaceholderConst() {
    $this->assertTrue(is_string(CURRY_PLACEHOLDER));
  }
}

?>
