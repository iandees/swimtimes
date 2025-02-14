<?php


	
class MeetMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.MeetMapBuilder';	

    
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
		
		$tMap = $this->dbMap->addTable('sw_meet');
		$tMap->setPhpName('Meet');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false);

		$tMap->addColumn('STARTDATE', 'Startdate', 'int', CreoleTypes::TIMESTAMP, false);

		$tMap->addColumn('ENDDATE', 'Enddate', 'int', CreoleTypes::TIMESTAMP, false);

		$tMap->addForeignKey('POOL_ID', 'PoolId', 'int', CreoleTypes::INTEGER, 'sw_pool', 'ID', false, null);
				
    } 
} 