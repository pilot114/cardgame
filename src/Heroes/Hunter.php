<?php

namespace Cardgame\Heroes;

class Hunter extends Hero
{
  public function isPowerRequireTarget()
  {
    return false;
  }

  public function power($target = null)
  {
    return 'hunter power';
  }
}
