<?php

namespace Cardgame\Heroes;

class Mage extends Hero
{
  public function isPowerRequireTarget()
  {
    return true;
  }

  public function power($target = null)
  {
    return 'mage power';
  }
}
