<?php

namespace Plojure;
use Closure;

class Plojure implements PlojureContract
{
  static $instance;

  private function construct() {}

  public static function get()
  {
    if (!static::$instance) {
      static::$instance = new static;
    }

    return static::$instance;
  }

  public function curry(Closure $fn)
  {
    return $fn;
  }

  public function map(Closure $fn, array $data = null)
  {
    return $fn;
  }

  public function filter(Closure $fn, array $data = null)
  {
    return $fn;
  }
  public function reduce(Closure $fn, $initialValue, array $data = null)
  {
    return $fn;
  }
}
