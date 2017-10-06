<?php

namespace Plojure;
use Closure;

interface PlojureContract
{
  public static function curry(callable $fn);
  public static function map(callable $fn, array $data = null);
  public static function filter(callable $fn, array $data = null);
  public static function reduce(callable $fn, $initialValue, array $data = null);
}
