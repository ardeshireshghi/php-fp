<?php

namespace Plojure;
use Closure;

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
  static $instance;

  public static function get()
  {
    if (!static::$instance) {
      static::$instance = new static;
    }

    return static::$instance;
  }

  public function curry(callable $fn)
  {
    return curry($fn);
  }

  public function map(callable $fn, array $data = null)
  {
    if (is_array($data)) {
      return array_map($fn, $data);
    }

    $curriedMap = curry('array_map');
    return $curriedMap($fn);
  }

  public function filter(callable $fn, array $data = null)
  {
    //TODO
  }
  public function reduce(callable $fn, $initialValue, array $data = null)
  {
    //TODO
  }
}
