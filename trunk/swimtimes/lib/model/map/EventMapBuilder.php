<?php


	
class EventMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.EventMapBuilder';	

    
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
		
		$tMap = $this->dbMap->addTable('sw_event');
		$tMap->setPhpName('Event');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false);

		$tMap->addColumn('DISTANCE', 'Distance', 'int', CreoleTypes::INTEGER, false);

		$tMap->addColumn('SPLITAT', 'Splitat', 'int', CreoleTypes::INTEGER, false);
				
    } 
} 