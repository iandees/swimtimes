<?php


abstract class BaseTimePeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'sw_time';

	
	const CLASS_DEFAULT = 'lib.model.Time';

	
	const NUM_COLUMNS = 7;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'sw_time.ID';

	
	const SWIMMER_ID = 'sw_time.SWIMMER_ID';

	
	const MEET_ID = 'sw_time.MEET_ID';

	
	const EVENT_ID = 'sw_time.EVENT_ID';

	
	const TIME = 'sw_time.TIME';

	
	const PLACE = 'sw_time.PLACE';

	
	const LANE = 'sw_time.LANE';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'SwimmerId', 'MeetId', 'EventId', 'Time', 'Place', 'Lane', ),
		BasePeer::TYPE_COLNAME => array (TimePeer::ID, TimePeer::SWIMMER_ID, TimePeer::MEET_ID, TimePeer::EVENT_ID, TimePeer::TIME, TimePeer::PLACE, TimePeer::LANE, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'swimmer_id', 'meet_id', 'event_id', 'time', 'place', 'lane', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'SwimmerId' => 1, 'MeetId' => 2, 'EventId' => 3, 'Time' => 4, 'Place' => 5, 'Lane' => 6, ),
		BasePeer::TYPE_COLNAME => array (TimePeer::ID => 0, TimePeer::SWIMMER_ID => 1, TimePeer::MEET_ID => 2, TimePeer::EVENT_ID => 3, TimePeer::TIME => 4, TimePeer::PLACE => 5, TimePeer::LANE => 6, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'swimmer_id' => 1, 'meet_id' => 2, 'event_id' => 3, 'time' => 4, 'place' => 5, 'lane' => 6, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/TimeMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.TimeMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = TimePeer::getTableMap();
			$columns = $map->getColumns();
			$nameMap = array();
			foreach ($columns as $column) {
				$nameMap[$column->getPhpName()] = $column->getColumnName();
			}
			self::$phpNameMap = $nameMap;
		}
		return self::$phpNameMap;
	}
	
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	
	public static function alias($alias, $column)
	{
		return str_replace(TimePeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(TimePeer::ID);

		$criteria->addSelectColumn(TimePeer::SWIMMER_ID);

		$criteria->addSelectColumn(TimePeer::MEET_ID);

		$criteria->addSelectColumn(TimePeer::EVENT_ID);

		$criteria->addSelectColumn(TimePeer::TIME);

		$criteria->addSelectColumn(TimePeer::PLACE);

		$criteria->addSelectColumn(TimePeer::LANE);

	}

	const COUNT = 'COUNT(sw_time.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT sw_time.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TimePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TimePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = TimePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}
	
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = TimePeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return TimePeer::populateObjects(TimePeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			TimePeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = TimePeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinSwimmer(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;
		
				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TimePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TimePeer::COUNT);
		}
		
				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(TimePeer::SWIMMER_ID, SwimmerPeer::ID);

		$rs = TimePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinMeet(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;
		
				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TimePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TimePeer::COUNT);
		}
		
				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(TimePeer::MEET_ID, MeetPeer::ID);

		$rs = TimePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinEvent(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;
		
				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TimePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TimePeer::COUNT);
		}
		
				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(TimePeer::EVENT_ID, EventPeer::ID);

		$rs = TimePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinSwimmer(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		TimePeer::addSelectColumns($c);
		$startcol = (TimePeer::NUM_COLUMNS - TimePeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		SwimmerPeer::addSelectColumns($c);

		$c->addJoin(TimePeer::SWIMMER_ID, SwimmerPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = TimePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = SwimmerPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getSwimmer(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addTime($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initTimes();
				$obj2->addTime($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinMeet(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		TimePeer::addSelectColumns($c);
		$startcol = (TimePeer::NUM_COLUMNS - TimePeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		MeetPeer::addSelectColumns($c);

		$c->addJoin(TimePeer::MEET_ID, MeetPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = TimePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = MeetPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getMeet(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addTime($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initTimes();
				$obj2->addTime($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinEvent(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		TimePeer::addSelectColumns($c);
		$startcol = (TimePeer::NUM_COLUMNS - TimePeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		EventPeer::addSelectColumns($c);

		$c->addJoin(TimePeer::EVENT_ID, EventPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = TimePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = EventPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getEvent(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addTime($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initTimes();
				$obj2->addTime($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TimePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TimePeer::COUNT);
		}
		
				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(TimePeer::SWIMMER_ID, SwimmerPeer::ID);

		$criteria->addJoin(TimePeer::MEET_ID, MeetPeer::ID);

		$criteria->addJoin(TimePeer::EVENT_ID, EventPeer::ID);

		$rs = TimePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAll(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		TimePeer::addSelectColumns($c);
		$startcol2 = (TimePeer::NUM_COLUMNS - TimePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		SwimmerPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + SwimmerPeer::NUM_COLUMNS;

		MeetPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + MeetPeer::NUM_COLUMNS;

		EventPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + EventPeer::NUM_COLUMNS;

		$c->addJoin(TimePeer::SWIMMER_ID, SwimmerPeer::ID);

		$c->addJoin(TimePeer::MEET_ID, MeetPeer::ID);

		$c->addJoin(TimePeer::EVENT_ID, EventPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();
		
		while($rs->next()) {

			$omClass = TimePeer::getOMClass();

			
			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

				
					
			$omClass = SwimmerPeer::getOMClass();

	
			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);
			
			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getSwimmer(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addTime($obj1); 					break;
				}
			}
			
			if ($newObject) {
				$obj2->initTimes();
				$obj2->addTime($obj1);
			}

				
					
			$omClass = MeetPeer::getOMClass();

	
			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);
			
			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getMeet(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addTime($obj1); 					break;
				}
			}
			
			if ($newObject) {
				$obj3->initTimes();
				$obj3->addTime($obj1);
			}

				
					
			$omClass = EventPeer::getOMClass();

	
			$cls = Propel::import($omClass);
			$obj4 = new $cls();
			$obj4->hydrate($rs, $startcol4);
			
			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getEvent(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addTime($obj1); 					break;
				}
			}
			
			if ($newObject) {
				$obj4->initTimes();
				$obj4->addTime($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptSwimmer(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;
		
				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TimePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TimePeer::COUNT);
		}
		
				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(TimePeer::MEET_ID, MeetPeer::ID);

		$criteria->addJoin(TimePeer::EVENT_ID, EventPeer::ID);

		$rs = TimePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptMeet(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;
		
				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TimePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TimePeer::COUNT);
		}
		
				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(TimePeer::SWIMMER_ID, SwimmerPeer::ID);

		$criteria->addJoin(TimePeer::EVENT_ID, EventPeer::ID);

		$rs = TimePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptEvent(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;
		
				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TimePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TimePeer::COUNT);
		}
		
				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(TimePeer::SWIMMER_ID, SwimmerPeer::ID);

		$criteria->addJoin(TimePeer::MEET_ID, MeetPeer::ID);

		$rs = TimePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptSwimmer(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		TimePeer::addSelectColumns($c);
		$startcol2 = (TimePeer::NUM_COLUMNS - TimePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		MeetPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + MeetPeer::NUM_COLUMNS;

		EventPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + EventPeer::NUM_COLUMNS;

		$c->addJoin(TimePeer::MEET_ID, MeetPeer::ID);

		$c->addJoin(TimePeer::EVENT_ID, EventPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();
		
		while($rs->next()) {

			$omClass = TimePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);		

			$omClass = MeetPeer::getOMClass();

	
			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);
			
			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getMeet(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addTime($obj1);
					break;
				}
			}
			
			if ($newObject) {
				$obj2->initTimes();
				$obj2->addTime($obj1);
			}

			$omClass = EventPeer::getOMClass();

	
			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);
			
			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getEvent(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addTime($obj1);
					break;
				}
			}
			
			if ($newObject) {
				$obj3->initTimes();
				$obj3->addTime($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptMeet(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		TimePeer::addSelectColumns($c);
		$startcol2 = (TimePeer::NUM_COLUMNS - TimePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		SwimmerPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + SwimmerPeer::NUM_COLUMNS;

		EventPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + EventPeer::NUM_COLUMNS;

		$c->addJoin(TimePeer::SWIMMER_ID, SwimmerPeer::ID);

		$c->addJoin(TimePeer::EVENT_ID, EventPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();
		
		while($rs->next()) {

			$omClass = TimePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);		

			$omClass = SwimmerPeer::getOMClass();

	
			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);
			
			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getSwimmer(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addTime($obj1);
					break;
				}
			}
			
			if ($newObject) {
				$obj2->initTimes();
				$obj2->addTime($obj1);
			}

			$omClass = EventPeer::getOMClass();

	
			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);
			
			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getEvent(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addTime($obj1);
					break;
				}
			}
			
			if ($newObject) {
				$obj3->initTimes();
				$obj3->addTime($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptEvent(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		TimePeer::addSelectColumns($c);
		$startcol2 = (TimePeer::NUM_COLUMNS - TimePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		SwimmerPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + SwimmerPeer::NUM_COLUMNS;

		MeetPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + MeetPeer::NUM_COLUMNS;

		$c->addJoin(TimePeer::SWIMMER_ID, SwimmerPeer::ID);

		$c->addJoin(TimePeer::MEET_ID, MeetPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();
		
		while($rs->next()) {

			$omClass = TimePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);		

			$omClass = SwimmerPeer::getOMClass();

	
			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);
			
			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getSwimmer(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addTime($obj1);
					break;
				}
			}
			
			if ($newObject) {
				$obj2->initTimes();
				$obj2->addTime($obj1);
			}

			$omClass = MeetPeer::getOMClass();

	
			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);
			
			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getMeet(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addTime($obj1);
					break;
				}
			}
			
			if ($newObject) {
				$obj3->initTimes();
				$obj3->addTime($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}

	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return TimePeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(TimePeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(TimePeer::ID);
			$selectCriteria->add(TimePeer::ID, $criteria->remove(TimePeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; 		try {
									$con->begin();
			$affectedRows += BasePeer::doDeleteAll(TimePeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	 public static function doDelete($values, $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(TimePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof Time) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(TimePeer::ID, (array) $values, Criteria::IN);
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->begin();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public static function doValidate(Time $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(TimePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(TimePeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		$res =  BasePeer::doValidate(TimePeer::DATABASE_NAME, TimePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = TimePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(TimePeer::DATABASE_NAME);

		$criteria->add(TimePeer::ID, $pk);


		$v = TimePeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria();
			$criteria->add(TimePeer::ID, $pks, Criteria::IN);
			$objs = TimePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseTimePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/TimeMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.TimeMapBuilder');
}
