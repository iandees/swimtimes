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
 *
 * sfActionStackEntry represents information relating to a single Action request
 * during a single HTTP request.
 *
 * @package    symfony
 * @subpackage action
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author     Sean Kerr <skerr@mojavi.org>
 * @version    SVN: $Id: sfActionStackEntry.class.php 2195 2006-09-26 13:06:47Z fabien $
 */
class sfActionStackEntry
{
  protected
    $actionInstance = null,
    $actionName     = null,
    $moduleName     = null,
    $presentation   = null,
    $viewInstance   = null;

  /**
   * Class constructor.
   *
   * @param string A module name.
   * @param string An action name.
   * @param sfAction An action implementation instance.
   *
   * @return void
   */
  public function __construct ($moduleName, $actionName, $actionInstance)
  {
    $this->actionName     = $actionName;
    $this->actionInstance = $actionInstance;
    $this->moduleName     = $moduleName;
  }

  /**
   * Retrieve this entry's action name.
   *
   * @return string An action name.
   */
  public function getActionName ()
  {
    return $this->actionName;
  }

  /**
   * Retrieve this entry's action instance.
   *
   * @return sfAction An action implementation instance.
   */
  public function getActionInstance ()
  {
    return $this->actionInstance;
  }

  /**
   * Retrieve this entry's view instance.
   *
   * @return sfView A view implementation instance.
   */
  public function getViewInstance ()
  {
    return $this->viewInstance;
  }

  /**
   * set this entry's view instance.
   *
   * @param sfView A view implementation instance.
   *
   * @return void
   */
  public function setViewInstance ($viewInstance)
  {
    $this->viewInstance = $viewInstance;
  }

  /**
   * Retrieve this entry's module name.
   *
   * @return string A module name.
   */
  public function getModuleName ()
  {
    return $this->moduleName;
  }

  /**
   * Retrieve this entry's rendered view presentation.
   *
   * This will only exist if the view has processed and the render mode
   * is set to sfView::RENDER_VAR.
   *
   * @return string An action name.
   */
  public function & getPresentation ()
  {
    return $this->presentation;
  }

  /**
   * Set the rendered presentation for this action.
   *
   * @param string A rendered presentation.
   *
   * @return void
   */
  public function setPresentation (&$presentation)
  {
    $this->presentation =& $presentation;
  }
}
