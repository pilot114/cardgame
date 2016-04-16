<?php

namespace Cardgame\Heroes;

class Mage extends Hero
{
  function __construct()
  {
  }

  public function isPowerRequireTarget()
  {
    return true;
  }

  public function power($target = null)
  {

  }
}
