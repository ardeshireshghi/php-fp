<?php

namespace Plojure;
use Closure;

const CURRY_PLACEHOLDER = 'plojure_curry_placeholder';

function partial(callable $fn, array $args) {
  return function() use ($fn, $args) {
    $mergedArgs = array_merge($args, func_get_args());
    return call_user_func_array($fn, $mergedArgs);
  };
}

function curry(callable $fn, $arity = null)
{
  $reflectionfn = new \ReflectionFunction($fn);
  $args = $reflectionfn->getParameters();
  $currentArity = ($arity !== null) ? $arity : count($args);

  $curryFunction = function() use ($currentArity, $fn) {
    $thisArgs = func_get_args();
    $argCount = count($thisArgs);

    // Call original function when arity matches
    if ($argCount === $currentArity) {
      return call_user_func_array($fn, $thisArgs);
    }

    $newFn = partial($fn, $thisArgs);
    return curry($newFn, $currentArity - $argCount);
  };

  return $curryFunction;
}

class Plojure implements PlojureContract
{
  public static function curry(callable $fn)
  {
    return curry($fn);
  }

  public static function map(callable $fn, array $data = null)
  {
    $handlerFn = 'array_map';

    if (is_array($data)) {
      return $handlerFn($fn, $data);
    }

    $curriedMap = curry($handlerFn);
    return $curriedMap($fn);
  }

  public static function filter(callable $fn, array $data = null)
  {
    $handlerFn = function($fn, $data) {
      return array_filter($data, $fn);
    };

    if (is_array($data)) {
      return $handlerFn($fn, $data);
    }

    $curriedFilter = curry($handlerFn);
    return $curriedFilter($fn);
  }

  public static function reduce(callable $fn, $initialValue, array $data = null)
  {
    $handlerFn = function($fn, $initialValue, $data) {
      $acc = $initialValue;

      foreach ($data as $index => $value) {
        $acc = $fn($acc, $value, $index, $data);
      }

      return $acc;
    };

    if (is_array($data)) {
      return $handlerFn($fn, $initialValue, $data);
    }

    $curriedReduce = curry($handlerFn);
    return $curriedReduce($fn, $initialValue);
  }
}
