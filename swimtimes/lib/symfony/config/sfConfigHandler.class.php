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
 * sfConfigHandler allows a developer to create a custom formatted configuration
 * file pertaining to any information they like and still have it auto-generate
 * PHP code.
 *
 * @package    symfony
 * @subpackage config
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author     Sean Kerr <skerr@mojavi.org>
 * @version    SVN: $Id: sfConfigHandler.class.php 2179 2006-09-25 16:02:57Z fabien $
 */
abstract class sfConfigHandler
{
  protected
    $parameter_holder = null;

  /**
   * Execute this configuration handler.
   *
   * @param array An array of filesystem path to a configuration file.
   *
   * @return string Data to be written to a cache file.
   *
   * @throws <b>sfConfigurationException</b> If a requested configuration file
   *                                       does not exist or is not readable.
   * @throws <b>sfParseException</b> If a requested configuration file is
   *                               improperly formatted.
   */
  abstract public function execute($configFiles);

  /**
   * Initialize this ConfigHandler.
   *
   * @param array An associative array of initialization parameters.
   *
   * @return bool true, if initialization completes successfully, otherwise false.
   *
   * @throws <b>sfInitializationException</b> If an error occurs while initializing this ConfigHandler.
   */
  public function initialize($parameters = null)
  {
    $this->parameter_holder = new sfParameterHolder();
    $this->parameter_holder->add($parameters);
  }

  /**
   * Replace constant identifiers in a value.
   *
   * If the value is an array replacements are made recursively.
   * 
   * @param mixed The value on which to run the replacement procedure.
   *
   * @return string The new value.
   */
  public static function replaceConstants($value)
  {
    if (is_array($value))
    {
      array_walk_recursive($value, create_function('&$value', '$value = sfToolkit::replaceConstants($value);'));
    }
    else
    {
      $value = sfToolkit::replaceConstants($value);
    }

    return $value;
  }

  /**
   * Replace a relative filesystem path with an absolute one.
   *
   * @param string A relative filesystem path.
   *
   * @return string The new path.
   */
  public static function replacePath($path)
  {
    if (!sfToolkit::isPathAbsolute($path))
    {
      // not an absolute path so we'll prepend to it
      $path = sfConfig::get('sf_app_dir').'/'.$path;
    }

    return $path;
  }

  public function getParameterHolder()
  {
    return $this->parameter_holder;
  }
}
