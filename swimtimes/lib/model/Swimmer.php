<?php

/**
 * Subclass for representing a row from the 'sw_swimmer' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Swimmer extends BaseSwimmer
{
  function __toString() {
    return $this->getName();
  }
}
