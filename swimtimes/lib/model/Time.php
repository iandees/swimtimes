<?php

/**
 * Subclass for representing a row from the 'sw_time' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Time extends BaseTime
{
  public function __toString() {
    return $this->formatAsTime();
  }

  public function formatAsTime() {
    $minutes = floor($this->getTime() / 60);
    $seconds = $this->getTime() - (60 * $minutes);
    return "$minutes:$seconds";
  }
}
