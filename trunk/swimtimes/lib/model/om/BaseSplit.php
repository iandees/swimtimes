<?php


abstract class BaseSplit extends BaseObject  implements Persistent {


	
	const DATABASE_NAME = 'propel';

	
	protected static $peer;


	
	protected $id;


	
	protected $time_id;


	
	protected $number;


	
	protected $time;

	
	protected $aTime;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getTimeId()
	{

		return $this->time_id;
	}

	
	public function getNumber()
	{

		return $this->number;
	}

	
	public function getTime()
	{

		return $this->time;
	}

	
	public function setId($v)
	{

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = SplitPeer::ID;
		}

	} 
	
	public function setTimeId($v)
	{

		if ($this->time_id !== $v) {
			$this->time_id = $v;
			$this->modifiedColumns[] = SplitPeer::TIME_ID;
		}

		if ($this->aTime !== null && $this->aTime->getId() !== $v) {
			$this->aTime = null;
		}

	} 
	
	public function setNumber($v)
	{

		if ($this->number !== $v) {
			$this->number = $v;
			$this->modifiedColumns[] = SplitPeer::NUMBER;
		}

	} 
	
	public function setTime($v)
	{

		if ($this->time !== $v) {
			$this->time = $v;
			$this->modifiedColumns[] = SplitPeer::TIME;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->time_id = $rs->getInt($startcol + 1);

			$this->number = $rs->getInt($startcol + 2);

			$this->time = $rs->getFloat($startcol + 3);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Split object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(SplitPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			SplitPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(SplitPeer::DATABASE_NAME);
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


												
			if ($this->aTime !== null) {
				if ($this->aTime->isModified()) {
					$affectedRows += $this->aTime->save($con);
				}
				$this->setTime($this->aTime);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = SplitPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += SplitPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

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


												
			if ($this->aTime !== null) {
				if (!$this->aTime->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aTime->getValidationFailures());
				}
			}


			if (($retval = SplitPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = SplitPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getTimeId();
				break;
			case 2:
				return $this->getNumber();
				break;
			case 3:
				return $this->getTime();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = SplitPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getTimeId(),
			$keys[2] => $this->getNumber(),
			$keys[3] => $this->getTime(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = SplitPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setTimeId($value);
				break;
			case 2:
				$this->setNumber($value);
				break;
			case 3:
				$this->setTime($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = SplitPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTimeId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setNumber($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTime($arr[$keys[3]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(SplitPeer::DATABASE_NAME);

		if ($this->isColumnModified(SplitPeer::ID)) $criteria->add(SplitPeer::ID, $this->id);
		if ($this->isColumnModified(SplitPeer::TIME_ID)) $criteria->add(SplitPeer::TIME_ID, $this->time_id);
		if ($this->isColumnModified(SplitPeer::NUMBER)) $criteria->add(SplitPeer::NUMBER, $this->number);
		if ($this->isColumnModified(SplitPeer::TIME)) $criteria->add(SplitPeer::TIME, $this->time);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(SplitPeer::DATABASE_NAME);

		$criteria->add(SplitPeer::ID, $this->id);

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

		$copyObj->setTimeId($this->time_id);

		$copyObj->setNumber($this->number);

		$copyObj->setTime($this->time);


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
			self::$peer = new SplitPeer();
		}
		return self::$peer;
	}

	
	public function setTime($v)
	{


		if ($v === null) {
			$this->setTimeId(NULL);
		} else {
			$this->setTimeId($v->getId());
		}


		$this->aTime = $v;
	}


	
	public function getTime($con = null)
	{
				include_once 'lib/model/om/BaseTimePeer.php';

		if ($this->aTime === null && ($this->time_id !== null)) {

			$this->aTime = TimePeer::retrieveByPK($this->time_id, $con);

			
		}
		return $this->aTime;
	}

} 