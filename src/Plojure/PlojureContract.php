<?php

namespace Plojure;
use Closure;

interface PlojureContract
{
  public function curry(callable $fn);
  public function map(callable $fn, array $data = null);
  public function filter(callable $fn, array $data = null);
  public function reduce(callable $fn, $initialValue, array $data = null);
}
