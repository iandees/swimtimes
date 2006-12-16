<?php


	
class PoolMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.PoolMapBuilder';	

    
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
		
		$tMap = $this->dbMap->addTable('sw_pool');
		$tMap->setPhpName('Pool');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false);

		$tMap->addColumn('LAT', 'Lat', 'double', CreoleTypes::DOUBLE, false);

		$tMap->addColumn('LNG', 'Lng', 'double', CreoleTypes::DOUBLE, false);
				
    } 
} 