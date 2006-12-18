<?php


	
class SplitMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.SplitMapBuilder';	

    
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
		
		$tMap = $this->dbMap->addTable('sw_split');
		$tMap->setPhpName('Split');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('TIME_ID', 'TimeId', 'int', CreoleTypes::INTEGER, 'sw_time', 'ID', false, null);

		$tMap->addColumn('NUMBER', 'Number', 'int', CreoleTypes::INTEGER, false);

		$tMap->addColumn('DURATION', 'Duration', 'double', CreoleTypes::DOUBLE, false);
				
    } 
} 