<?php


abstract class BaseEvent extends BaseObject  implements Persistent {


	
	const DATABASE_NAME = 'propel';

	
	protected static $peer;


	
	protected $id;


	
	protected $name;


	
	protected $distance;

	
	protected $collTimes;

	
	protected $lastTimeCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getName()
	{

		return $this->name;
	}

	
	public function getDistance()
	{

		return $this->distance;
	}

	
	public function setId($v)
	{

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = EventPeer::ID;
		}

	} 
	
	public function setName($v)
	{

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = EventPeer::NAME;
		}

	} 
	
	public function setDistance($v)
	{

		if ($this->distance !== $v) {
			$this->distance = $v;
			$this->modifiedColumns[] = EventPeer::DISTANCE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->distance = $rs->getInt($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Event object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(EventPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			EventPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(EventPeer::DATABASE_NAME);
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


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = EventPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += EventPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collTimes !== null) {
				foreach($this->collTimes as $referrerFK) {
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


			if (($retval = EventPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collTimes !== null) {
					foreach($this->collTimes as $referrerFK) {
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
		$pos = EventPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getName();
				break;
			case 2:
				return $this->getDistance();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = EventPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getDistance(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = EventPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setName($value);
				break;
			case 2:
				$this->setDistance($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = EventPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDistance($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(EventPeer::DATABASE_NAME);

		if ($this->isColumnModified(EventPeer::ID)) $criteria->add(EventPeer::ID, $this->id);
		if ($this->isColumnModified(EventPeer::NAME)) $criteria->add(EventPeer::NAME, $this->name);
		if ($this->isColumnModified(EventPeer::DISTANCE)) $criteria->add(EventPeer::DISTANCE, $this->distance);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(EventPeer::DATABASE_NAME);

		$criteria->add(EventPeer::ID, $this->id);

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

		$copyObj->setName($this->name);

		$copyObj->setDistance($this->distance);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getTimes() as $relObj) {
				$copyObj->addTime($relObj->copy($deepCopy));
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
			self::$peer = new EventPeer();
		}
		return self::$peer;
	}

	
	public function initTimes()
	{
		if ($this->collTimes === null) {
			$this->collTimes = array();
		}
	}

	
	public function getTimes($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseTimePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTimes === null) {
			if ($this->isNew()) {
			   $this->collTimes = array();
			} else {

				$criteria->add(TimePeer::EVENT_ID, $this->getId());

				TimePeer::addSelectColumns($criteria);
				$this->collTimes = TimePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(TimePeer::EVENT_ID, $this->getId());

				TimePeer::addSelectColumns($criteria);
				if (!isset($this->lastTimeCriteria) || !$this->lastTimeCriteria->equals($criteria)) {
					$this->collTimes = TimePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTimeCriteria = $criteria;
		return $this->collTimes;
	}

	
	public function countTimes($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseTimePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(TimePeer::EVENT_ID, $this->getId());

		return TimePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addTime(Time $l)
	{
		$this->collTimes[] = $l;
		$l->setEvent($this);
	}


	
	public function getTimesJoinSwimmer($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseTimePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTimes === null) {
			if ($this->isNew()) {
				$this->collTimes = array();
			} else {

				$criteria->add(TimePeer::EVENT_ID, $this->getId());

				$this->collTimes = TimePeer::doSelectJoinSwimmer($criteria, $con);
			}
		} else {
									
			$criteria->add(TimePeer::EVENT_ID, $this->getId());

			if (!isset($this->lastTimeCriteria) || !$this->lastTimeCriteria->equals($criteria)) {
				$this->collTimes = TimePeer::doSelectJoinSwimmer($criteria, $con);
			}
		}
		$this->lastTimeCriteria = $criteria;

		return $this->collTimes;
	}


	
	public function getTimesJoinMeet($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseTimePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTimes === null) {
			if ($this->isNew()) {
				$this->collTimes = array();
			} else {

				$criteria->add(TimePeer::EVENT_ID, $this->getId());

				$this->collTimes = TimePeer::doSelectJoinMeet($criteria, $con);
			}
		} else {
									
			$criteria->add(TimePeer::EVENT_ID, $this->getId());

			if (!isset($this->lastTimeCriteria) || !$this->lastTimeCriteria->equals($criteria)) {
				$this->collTimes = TimePeer::doSelectJoinMeet($criteria, $con);
			}
		}
		$this->lastTimeCriteria = $criteria;

		return $this->collTimes;
	}

} 