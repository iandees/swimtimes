<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Propel Admin generator.
 *
 * This class generates an admin module with propel.
 *
 * @package    symfony
 * @subpackage generator
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfPropelAdminGenerator.class.php 2728 2006-11-17 09:46:01Z chtito $
 */

class sfPropelAdminGenerator extends sfPropelCrudGenerator
{
  public function initialize($generatorManager)
  {
    parent::initialize($generatorManager);

    $this->setGeneratorClass('sfPropelAdmin');
  }

  public function getAllColumns()
  {
    $phpNames = array();
    foreach ($this->getTableMap()->getColumns() as $column)
    {
      $phpNames[] = new sfAdminColumn($column->getPhpName(), $column);
    }

    return $phpNames;
  }

  public function getAdminColumnForField($field, $flag = null)
  {
    $phpName = sfInflector::camelize($field);

    return new sfAdminColumn($phpName, $this->getColumnForPhpName($phpName), $flag);
  }

  // returns a column phpName or null if none was found
  public function getColumnForPhpName($phpName)
  {
    // search the matching column for this column name

    foreach ($this->getTableMap()->getColumns() as $column)
    {
      if ($column->getPhpName() == $phpName)
      {
        $found = true;

        return $column;
      }
    }

    // not a "real" column, so we will simulate one
    return null;
  }
}