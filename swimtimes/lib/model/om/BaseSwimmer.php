<?php


abstract class BaseSwimmer extends BaseObject  implements Persistent {


	
	const DATABASE_NAME = 'propel';

	
	protected static $peer;


	
	protected $id;


	
	protected $name;


	
	protected $year;


	
	protected $team_id;

	
	protected $aTeam;

	
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

	
	public function getYear()
	{

		return $this->year;
	}

	
	public function getTeamId()
	{

		return $this->team_id;
	}

	
	public function setId($v)
	{

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = SwimmerPeer::ID;
		}

	} 
	
	public function setName($v)
	{

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = SwimmerPeer::NAME;
		}

	} 
	
	public function setYear($v)
	{

		if ($this->year !== $v) {
			$this->year = $v;
			$this->modifiedColumns[] = SwimmerPeer::YEAR;
		}

	} 
	
	public function setTeamId($v)
	{

		if ($this->team_id !== $v) {
			$this->team_id = $v;
			$this->modifiedColumns[] = SwimmerPeer::TEAM_ID;
		}

		if ($this->aTeam !== null && $this->aTeam->getId() !== $v) {
			$this->aTeam = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->year = $rs->getInt($startcol + 2);

			$this->team_id = $rs->getInt($startcol + 3);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Swimmer object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(SwimmerPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			SwimmerPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(SwimmerPeer::DATABASE_NAME);
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


												
			if ($this->aTeam !== null) {
				if ($this->aTeam->isModified()) {
					$affectedRows += $this->aTeam->save($con);
				}
				$this->setTeam($this->aTeam);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = SwimmerPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += SwimmerPeer::doUpdate($this, $con);
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


												
			if ($this->aTeam !== null) {
				if (!$this->aTeam->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aTeam->getValidationFailures());
				}
			}


			if (($retval = SwimmerPeer::doValidate($this, $columns)) !== true) {
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
		$pos = SwimmerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getYear();
				break;
			case 3:
				return $this->getTeamId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = SwimmerPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getYear(),
			$keys[3] => $this->getTeamId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = SwimmerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setYear($value);
				break;
			case 3:
				$this->setTeamId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = SwimmerPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setYear($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTeamId($arr[$keys[3]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(SwimmerPeer::DATABASE_NAME);

		if ($this->isColumnModified(SwimmerPeer::ID)) $criteria->add(SwimmerPeer::ID, $this->id);
		if ($this->isColumnModified(SwimmerPeer::NAME)) $criteria->add(SwimmerPeer::NAME, $this->name);
		if ($this->isColumnModified(SwimmerPeer::YEAR)) $criteria->add(SwimmerPeer::YEAR, $this->year);
		if ($this->isColumnModified(SwimmerPeer::TEAM_ID)) $criteria->add(SwimmerPeer::TEAM_ID, $this->team_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(SwimmerPeer::DATABASE_NAME);

		$criteria->add(SwimmerPeer::ID, $this->id);

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

		$copyObj->setYear($this->year);

		$copyObj->setTeamId($this->team_id);


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
			self::$peer = new SwimmerPeer();
		}
		return self::$peer;
	}

	
	public function setTeam($v)
	{


		if ($v === null) {
			$this->setTeamId(NULL);
		} else {
			$this->setTeamId($v->getId());
		}


		$this->aTeam = $v;
	}


	
	public function getTeam($con = null)
	{
				include_once 'lib/model/om/BaseTeamPeer.php';

		if ($this->aTeam === null && ($this->team_id !== null)) {

			$this->aTeam = TeamPeer::retrieveByPK($this->team_id, $con);

			
		}
		return $this->aTeam;
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

				$criteria->add(TimePeer::SWIMMER_ID, $this->getId());

				TimePeer::addSelectColumns($criteria);
				$this->collTimes = TimePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(TimePeer::SWIMMER_ID, $this->getId());

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

		$criteria->add(TimePeer::SWIMMER_ID, $this->getId());

		return TimePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addTime(Time $l)
	{
		$this->collTimes[] = $l;
		$l->setSwimmer($this);
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

				$criteria->add(TimePeer::SWIMMER_ID, $this->getId());

				$this->collTimes = TimePeer::doSelectJoinMeet($criteria, $con);
			}
		} else {
									
			$criteria->add(TimePeer::SWIMMER_ID, $this->getId());

			if (!isset($this->lastTimeCriteria) || !$this->lastTimeCriteria->equals($criteria)) {
				$this->collTimes = TimePeer::doSelectJoinMeet($criteria, $con);
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

				$criteria->add(TimePeer::SWIMMER_ID, $this->getId());

				$this->collTimes = TimePeer::doSelectJoinEvent($criteria, $con);
			}
		} else {
									
			$criteria->add(TimePeer::SWIMMER_ID, $this->getId());

			if (!isset($this->lastTimeCriteria) || !$this->lastTimeCriteria->equals($criteria)) {
				$this->collTimes = TimePeer::doSelectJoinEvent($criteria, $con);
			}
		}
		$this->lastTimeCriteria = $criteria;

		return $this->collTimes;
	}

} 