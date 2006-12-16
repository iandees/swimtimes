<?php


	
class TeamMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.TeamMapBuilder';	

    
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
		
		$tMap = $this->dbMap->addTable('sw_team');
		$tMap->setPhpName('Team');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false);

		$tMap->addColumn('SHORTNAME', 'Shortname', 'string', CreoleTypes::VARCHAR, false);
				
    } 
} 