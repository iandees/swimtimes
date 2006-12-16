<?php

/**
 * Subclass for representing a row from the 'sw_team' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Team extends BaseTeam
{
  function __toString() {
    return $this->getName();
  }
}
