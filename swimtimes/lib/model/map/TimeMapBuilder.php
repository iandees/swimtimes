<?php


	
class TimeMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.TimeMapBuilder';	

    
    private $dbMap;

	
    public function isBuilt()
    {
        return ($this->dbMap !== null);
    }

	
    public function getDatabaseMap()
    {
        return $this->dbMap;
    }

    
    public function doBuild()
    {
		$this->dbMap = Propel::getDatabaseMap('propel');
		
		$tMap = $this->dbMap->addTable('sw_time');
		$tMap->setPhpName('Time');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('SWIMMER_ID', 'SwimmerId', 'int', CreoleTypes::INTEGER, 'sw_swimmer', 'ID', false, null);

		$tMap->addForeignKey('MEET_ID', 'MeetId', 'int', CreoleTypes::INTEGER, 'sw_meet', 'ID', false, null);

		$tMap->addForeignKey('EVENT_ID', 'EventId', 'int', CreoleTypes::INTEGER, 'sw_event', 'ID', false, null);

		$tMap->addColumn('TIME', 'Time', 'double', CreoleTypes::DOUBLE, false);

		$tMap->addColumn('PLACE', 'Place', 'int', CreoleTypes::INTEGER, false);

		$tMap->addColumn('POINTS', 'Points', 'int', CreoleTypes::INTEGER, false);

		$tMap->addColumn('LANE', 'Lane', 'int', CreoleTypes::INTEGER, false);
				
    } 
} 