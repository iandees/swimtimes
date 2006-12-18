<?php


abstract class BaseMeet extends BaseObject  implements Persistent {


	
	const DATABASE_NAME = 'propel';

	
	protected static $peer;


	
	protected $id;


	
	protected $name;


	
	protected $startdate;


	
	protected $enddate;


	
	protected $pool_id;

	
	protected $aPool;

	
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

	
	public function getStartdate($format = 'Y-m-d H:i:s')
	{

		if ($this->startdate === null || $this->startdate === '') {
			return null;
		} elseif (!is_int($this->startdate)) {
						$ts = strtotime($this->startdate);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [startdate] as date/time value: " . var_export($this->startdate, true));
			}
		} else {
			$ts = $this->startdate;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getEnddate($format = 'Y-m-d H:i:s')
	{

		if ($this->enddate === null || $this->enddate === '') {
			return null;
		} elseif (!is_int($this->enddate)) {
						$ts = strtotime($this->enddate);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [enddate] as date/time value: " . var_export($this->enddate, true));
			}
		} else {
			$ts = $this->enddate;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getPoolId()
	{

		return $this->pool_id;
	}

	
	public function setId($v)
	{

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = MeetPeer::ID;
		}

	} 
	
	public function setName($v)
	{

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = MeetPeer::NAME;
		}

	} 
	
	public function setStartdate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [startdate] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->startdate !== $ts) {
			$this->startdate = $ts;
			$this->modifiedColumns[] = MeetPeer::STARTDATE;
		}

	} 
	
	public function setEnddate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [enddate] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->enddate !== $ts) {
			$this->enddate = $ts;
			$this->modifiedColumns[] = MeetPeer::ENDDATE;
		}

	} 
	
	public function setPoolId($v)
	{

		if ($this->pool_id !== $v) {
			$this->pool_id = $v;
			$this->modifiedColumns[] = MeetPeer::POOL_ID;
		}

		if ($this->aPool !== null && $this->aPool->getId() !== $v) {
			$this->aPool = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->startdate = $rs->getTimestamp($startcol + 2, null);

			$this->enddate = $rs->getTimestamp($startcol + 3, null);

			$this->pool_id = $rs->getInt($startcol + 4);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Meet object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MeetPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MeetPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(MeetPeer::DATABASE_NAME);
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


												
			if ($this->aPool !== null) {
				if ($this->aPool->isModified()) {
					$affectedRows += $this->aPool->save($con);
				}
				$this->setPool($this->aPool);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = MeetPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += MeetPeer::doUpdate($this, $con);
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


												
			if ($this->aPool !== null) {
				if (!$this->aPool->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPool->getValidationFailures());
				}
			}


			if (($retval = MeetPeer::doValidate($this, $columns)) !== true) {
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
		$pos = MeetPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getStartdate();
				break;
			case 3:
				return $this->getEnddate();
				break;
			case 4:
				return $this->getPoolId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MeetPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getStartdate(),
			$keys[3] => $this->getEnddate(),
			$keys[4] => $this->getPoolId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MeetPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setStartdate($value);
				break;
			case 3:
				$this->setEnddate($value);
				break;
			case 4:
				$this->setPoolId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MeetPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setStartdate($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setEnddate($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setPoolId($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MeetPeer::DATABASE_NAME);

		if ($this->isColumnModified(MeetPeer::ID)) $criteria->add(MeetPeer::ID, $this->id);
		if ($this->isColumnModified(MeetPeer::NAME)) $criteria->add(MeetPeer::NAME, $this->name);
		if ($this->isColumnModified(MeetPeer::STARTDATE)) $criteria->add(MeetPeer::STARTDATE, $this->startdate);
		if ($this->isColumnModified(MeetPeer::ENDDATE)) $criteria->add(MeetPeer::ENDDATE, $this->enddate);
		if ($this->isColumnModified(MeetPeer::POOL_ID)) $criteria->add(MeetPeer::POOL_ID, $this->pool_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MeetPeer::DATABASE_NAME);

		$criteria->add(MeetPeer::ID, $this->id);

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

		$copyObj->setStartdate($this->startdate);

		$copyObj->setEnddate($this->enddate);

		$copyObj->setPoolId($this->pool_id);


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
			self::$peer = new MeetPeer();
		}
		return self::$peer;
	}

	
	public function setPool($v)
	{


		if ($v === null) {
			$this->setPoolId(NULL);
		} else {
			$this->setPoolId($v->getId());
		}


		$this->aPool = $v;
	}


	
	public function getPool($con = null)
	{
				include_once 'lib/model/om/BasePoolPeer.php';

		if ($this->aPool === null && ($this->pool_id !== null)) {

			$this->aPool = PoolPeer::retrieveByPK($this->pool_id, $con);

			
		}
		return $this->aPool;
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

				$criteria->add(TimePeer::MEET_ID, $this->getId());

				TimePeer::addSelectColumns($criteria);
				$this->collTimes = TimePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(TimePeer::MEET_ID, $this->getId());

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

		$criteria->add(TimePeer::MEET_ID, $this->getId());

		return TimePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addTime(Time $l)
	{
		$this->collTimes[] = $l;
		$l->setMeet($this);
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

				$criteria->add(TimePeer::MEET_ID, $this->getId());

				$this->collTimes = TimePeer::doSelectJoinSwimmer($criteria, $con);
			}
		} else {
									
			$criteria->add(TimePeer::MEET_ID, $this->getId());

			if (!isset($this->lastTimeCriteria) || !$this->lastTimeCriteria->equals($criteria)) {
				$this->collTimes = TimePeer::doSelectJoinSwimmer($criteria, $con);
			}
		}
		$this->lastTimeCriteria = $criteria;

		return $this->collTimes;
	}


	
	public function getTimesJoinEvent($criteria = null, $con = null)
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

				$criteria->add(TimePeer::MEET_ID, $this->getId());

				$this->collTimes = TimePeer::doSelectJoinEvent($criteria, $con);
			}
		} else {
									
			$criteria->add(TimePeer::MEET_ID, $this->getId());

			if (!isset($this->lastTimeCriteria) || !$this->lastTimeCriteria->equals($criteria)) {
				$this->collTimes = TimePeer::doSelectJoinEvent($criteria, $con);
			}
		}
		$this->lastTimeCriteria = $criteria;

		return $this->collTimes;
	}

} 