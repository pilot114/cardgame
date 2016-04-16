<?php

namespace Cardgame\Heroes;

abstract class Hero
{
  function __construct()
  {
  }

  abstract function isPowerRequireTarget();
  abstract function power($target = null);
}
