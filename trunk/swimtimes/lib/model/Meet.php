<?php

/**
 * Subclass for representing a row from the 'sw_meet' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Meet extends BaseMeet
{
  public function __toString() {
    return $this->getName();
  }
}
