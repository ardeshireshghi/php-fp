<?php

namespace Plojure;
use Closure;

interface PlojureContract
{
  public function curry(Closure $fn);
  public function map(Closure $fn, array $data = null);
  public function filter(Closure $fn, array $data = null);
  public function reduce(Closure $fn, $initialValue, array $data = null);
}
