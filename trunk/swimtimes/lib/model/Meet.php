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

  public function getNumTimes() {
    return count($this->getTimes());
  }

  public function getEvents() {
    // Right now this returns all of the events, but it could be made
    // to return only the events that were happening at this meet.
    return EventPeer::doSelect(new Criteria());
  }

  public function getSwimmers() {
    return SwimmerPeer::doSelect(new Criteria());
  }
}
