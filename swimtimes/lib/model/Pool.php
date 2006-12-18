<?php

/**
 * Subclass for representing a row from the 'sw_pool' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Pool extends BasePool
{
  public function __toString() {
    return $this->getName();
  }
}
