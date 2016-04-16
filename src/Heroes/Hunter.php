<?php

namespace Cardgame\Heroes;

class Hunter extends Hero
{
  function __construct()
  {
  }

  public function isPowerRequireTarget()
  {
    return false;
  }

  public function power($target = null)
  {
    return 'hunter power';
  }
}
