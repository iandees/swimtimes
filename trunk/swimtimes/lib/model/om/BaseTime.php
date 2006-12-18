<?php


abstract class BaseTime extends BaseObject  implements Persistent {


	
	const DATABASE_NAME = 'propel';

	
	protected static $peer;


	
	protected $id;


	
	protected $swimmer_id;


	
	protected $meet_id;


	
	protected $event_id;


	
	protected $time;


	
	protected $place;


	
	protected $points;


	
	protected $lane;

	
	protected $aSwimmer;

	
	protected $aMeet;

	
	protected $aEvent;

	
	protected $collSplits;

	
	protected $lastSplitCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getSwimmerId()
	{

		return $this->swimmer_id;
	}

	
	public function getMeetId()
	{

		return $this->meet_id;
	}

	
	public function getEventId()
	{

		return $this->event_id;
	}

	
	public function getTime()
	{

		return $this->time;
	}

	
	public function getPlace()
	{

		return $this->place;
	}

	
	public function getPoints()
	{

		return $this->points;
	}

	
	public function getLane()
	{

		return $this->lane;
	}

	
	public function setId($v)
	{

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = TimePeer::ID;
		}

	} 
	
	public function setSwimmerId($v)
	{

		if ($this->swimmer_id !== $v) {
			$this->swimmer_id = $v;
			$this->modifiedColumns[] = TimePeer::SWIMMER_ID;
		}

		if ($this->aSwimmer !== null && $this->aSwimmer->getId() !== $v) {
			$this->aSwimmer = null;
		}

	} 
	
	public function setMeetId($v)
	{

		if ($this->meet_id !== $v) {
			$this->meet_id = $v;
			$this->modifiedColumns[] = TimePeer::MEET_ID;
		}

		if ($this->aMeet !== null && $this->aMeet->getId() !== $v) {
			$this->aMeet = null;
		}

	} 
	
	public function setEventId($v)
	{

		if ($this->event_id !== $v) {
			$this->event_id = $v;
			$this->modifiedColumns[] = TimePeer::EVENT_ID;
		}

		if ($this->aEvent !== null && $this->aEvent->getId() !== $v) {
			$this->aEvent = null;
		}

	} 
	
	public function setTime($v)
	{

		if ($this->time !== $v) {
			$this->time = $v;
			$this->modifiedColumns[] = TimePeer::TIME;
		}

	} 
	
	public function setPlace($v)
	{

		if ($this->place !== $v) {
			$this->place = $v;
			$this->modifiedColumns[] = TimePeer::PLACE;
		}

	} 
	
	public function setPoints($v)
	{

		if ($this->points !== $v) {
			$this->points = $v;
			$this->modifiedColumns[] = TimePeer::POINTS;
		}

	} 
	
	public function setLane($v)
	{

		if ($this->lane !== $v) {
			$this->lane = $v;
			$this->modifiedColumns[] = TimePeer::LANE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->swimmer_id = $rs->getInt($startcol + 1);

			$this->meet_id = $rs->getInt($startcol + 2);

			$this->event_id = $rs->getInt($startcol + 3);

			$this->time = $rs->getFloat($startcol + 4);

			$this->place = $rs->getInt($startcol + 5);

			$this->points = $rs->getInt($startcol + 6);

			$this->lane = $rs->getInt($startcol + 7);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 8; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Time object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(TimePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			TimePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(TimePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected function doSave($con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


												
			if ($this->aSwimmer !== null) {
				if ($this->aSwimmer->isModified()) {
					$affectedRows += $this->aSwimmer->save($con);
				}
				$this->setSwimmer($this->aSwimmer);
			}

			if ($this->aMeet !== null) {
				if ($this->aMeet->isModified()) {
					$affectedRows += $this->aMeet->save($con);
				}
				$this->setMeet($this->aMeet);
			}

			if ($this->aEvent !== null) {
				if ($this->aEvent->isModified()) {
					$affectedRows += $this->aEvent->save($con);
				}
				$this->setEvent($this->aEvent);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = TimePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += TimePeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collSplits !== null) {
				foreach($this->collSplits as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


												
			if ($this->aSwimmer !== null) {
				if (!$this->aSwimmer->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aSwimmer->getValidationFailures());
				}
			}

			if ($this->aMeet !== null) {
				if (!$this->aMeet->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aMeet->getValidationFailures());
				}
			}

			if ($this->aEvent !== null) {
				if (!$this->aEvent->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aEvent->getValidationFailures());
				}
			}


			if (($retval = TimePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collSplits !== null) {
					foreach($this->collSplits as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TimePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getSwimmerId();
				break;
			case 2:
				return $this->getMeetId();
				break;
			case 3:
				return $this->getEventId();
				break;
			case 4:
				return $this->getTime();
				break;
			case 5:
				return $this->getPlace();
				break;
			case 6:
				return $this->getPoints();
				break;
			case 7:
				return $this->getLane();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TimePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getSwimmerId(),
			$keys[2] => $this->getMeetId(),
			$keys[3] => $this->getEventId(),
			$keys[4] => $this->getTime(),
			$keys[5] => $this->getPlace(),
			$keys[6] => $this->getPoints(),
			$keys[7] => $this->getLane(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TimePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setSwimmerId($value);
				break;
			case 2:
				$this->setMeetId($value);
				break;
			case 3:
				$this->setEventId($value);
				break;
			case 4:
				$this->setTime($value);
				break;
			case 5:
				$this->setPlace($value);
				break;
			case 6:
				$this->setPoints($value);
				break;
			case 7:
				$this->setLane($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TimePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setSwimmerId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setMeetId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setEventId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setTime($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setPlace($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setPoints($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setLane($arr[$keys[7]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(TimePeer::DATABASE_NAME);

		if ($this->isColumnModified(TimePeer::ID)) $criteria->add(TimePeer::ID, $this->id);
		if ($this->isColumnModified(TimePeer::SWIMMER_ID)) $criteria->add(TimePeer::SWIMMER_ID, $this->swimmer_id);
		if ($this->isColumnModified(TimePeer::MEET_ID)) $criteria->add(TimePeer::MEET_ID, $this->meet_id);
		if ($this->isColumnModified(TimePeer::EVENT_ID)) $criteria->add(TimePeer::EVENT_ID, $this->event_id);
		if ($this->isColumnModified(TimePeer::TIME)) $criteria->add(TimePeer::TIME, $this->time);
		if ($this->isColumnModified(TimePeer::PLACE)) $criteria->add(TimePeer::PLACE, $this->place);
		if ($this->isColumnModified(TimePeer::POINTS)) $criteria->add(TimePeer::POINTS, $this->points);
		if ($this->isColumnModified(TimePeer::LANE)) $criteria->add(TimePeer::LANE, $this->lane);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(TimePeer::DATABASE_NAME);

		$criteria->add(TimePeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setSwimmerId($this->swimmer_id);

		$copyObj->setMeetId($this->meet_id);

		$copyObj->setEventId($this->event_id);

		$copyObj->setTime($this->time);

		$copyObj->setPlace($this->place);

		$copyObj->setPoints($this->points);

		$copyObj->setLane($this->lane);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getSplits() as $relObj) {
				$copyObj->addSplit($relObj->copy($deepCopy));
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new TimePeer();
		}
		return self::$peer;
	}

	
	public function setSwimmer($v)
	{


		if ($v === null) {
			$this->setSwimmerId(NULL);
		} else {
			$this->setSwimmerId($v->getId());
		}


		$this->aSwimmer = $v;
	}


	
	public function getSwimmer($con = null)
	{
				include_once 'lib/model/om/BaseSwimmerPeer.php';

		if ($this->aSwimmer === null && ($this->swimmer_id !== null)) {

			$this->aSwimmer = SwimmerPeer::retrieveByPK($this->swimmer_id, $con);

			
		}
		return $this->aSwimmer;
	}

	
	public function setMeet($v)
	{


		if ($v === null) {
			$this->setMeetId(NULL);
		} else {
			$this->setMeetId($v->getId());
		}


		$this->aMeet = $v;
	}


	
	public function getMeet($con = null)
	{
				include_once 'lib/model/om/BaseMeetPeer.php';

		if ($this->aMeet === null && ($this->meet_id !== null)) {

			$this->aMeet = MeetPeer::retrieveByPK($this->meet_id, $con);

			
		}
		return $this->aMeet;
	}

	
	public function setEvent($v)
	{


		if ($v === null) {
			$this->setEventId(NULL);
		} else {
			$this->setEventId($v->getId());
		}


		$this->aEvent = $v;
	}


	
	public function getEvent($con = null)
	{
				include_once 'lib/model/om/BaseEventPeer.php';

		if ($this->aEvent === null && ($this->event_id !== null)) {

			$this->aEvent = EventPeer::retrieveByPK($this->event_id, $con);

			
		}
		return $this->aEvent;
	}

	
	public function initSplits()
	{
		if ($this->collSplits === null) {
			$this->collSplits = array();
		}
	}

	
	public function getSplits($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseSplitPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSplits === null) {
			if ($this->isNew()) {
			   $this->collSplits = array();
			} else {

				$criteria->add(SplitPeer::TIME_ID, $this->getId());

				SplitPeer::addSelectColumns($criteria);
				$this->collSplits = SplitPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(SplitPeer::TIME_ID, $this->getId());

				SplitPeer::addSelectColumns($criteria);
				if (!isset($this->lastSplitCriteria) || !$this->lastSplitCriteria->equals($criteria)) {
					$this->collSplits = SplitPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastSplitCriteria = $criteria;
		return $this->collSplits;
	}

	
	public function countSplits($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseSplitPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(SplitPeer::TIME_ID, $this->getId());

		return SplitPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addSplit(Split $l)
	{
		$this->collSplits[] = $l;
		$l->setTime($this);
	}

} 