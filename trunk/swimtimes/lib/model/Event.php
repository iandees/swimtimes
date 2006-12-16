<?php

/**
 * Subclass for representing a row from the 'sw_event' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Event extends BaseEvent
{
  public function __toString() {
    return $this->getName();
  }
}
