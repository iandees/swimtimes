<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 * (c) 2004-2006 Sean Kerr.
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfActionException is thrown when an error occurs in an action.
 *
 * @package    symfony
 * @subpackage exception
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author     Sean Kerr <skerr@mojavi.org>
 * @version    SVN: $Id: sfActionException.class.php 1415 2006-06-11 08:33:51Z fabien $
 */
class sfActionException extends sfException
{
  /**
   * Class constructor.
   *
   * @param string The error message.
   * @param int    The error code.
   */
  public function __construct ($message = null, $code = 0)
  {
    $this->setName('sfActionException');
    parent::__construct($message, $code);
  }
}
