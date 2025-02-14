<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfYamlConfigHandler is a base class for YAML (.yml) configuration handlers. This class
 * provides a central location for parsing YAML files and detecting required categories.
 *
 * @package    symfony
 * @subpackage config
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfYamlConfigHandler.class.php 2181 2006-09-25 16:25:29Z fabien $
 */
abstract class sfYamlConfigHandler extends sfConfigHandler
{
  protected
    $yamlConfig = null;

  protected function parseYamls($configFiles)
  {
    $config = array();
    foreach ($configFiles as $configFile)
    {
      $config = sfToolkit::arrayDeepMerge($config, $this->parseYaml($configFile));
    }

    return $config;
  }

  /**
   * Parse a YAML (.yml) configuration file.
   *
   * @param string An absolute filesystem path to a configuration file.
   *
   * @return string A parsed .yml configuration.
   *
   * @throws sfConfigurationException If a requested configuration file does not exist or is not readable.
   * @throws sfParseException If a requested configuration file is improperly formatted.
   */
  protected function parseYaml($configFile)
  {
    if (!is_readable($configFile))
    {
      // can't read the configuration
      $error = sprintf('Configuration file "%s" does not exist or is not readable', $configFile);

      throw new sfConfigurationException($error);
    }

    // parse our config
    $config = sfYaml::load($configFile);

    if ($config === false || $config === null)
    {
      // configuration couldn't be parsed
      $error = sprintf('Configuration file "%s" could not be parsed', $configFile);
      throw new sfParseException($error);
    }

    // get a list of the required categories
    $categories = $this->getParameterHolder()->get('required_categories', array());
    foreach ($categories as $category)
    {
      if (!isset($config[$category]))
      {
        $error = sprintf('Configuration file "%s" is missing "%s" category', $configFile, $category);
        throw new sfParseException($error);
      }
    }

    return $config;
  }

  protected function mergeConfigValue($keyName, $category)
  {
    $values = array();

    if (isset($this->yamlConfig['all'][$keyName]) && is_array($this->yamlConfig['all'][$keyName]))
    {
      $values = $this->yamlConfig['all'][$keyName];
    }

    if ($category && isset($this->yamlConfig[$category][$keyName]) && is_array($this->yamlConfig[$category][$keyName]))
    {
      $values = array_merge($values, $this->yamlConfig[$category][$keyName]);
    }

    return $values;
  }

  protected function getConfigValue($keyName, $category, $defaultValue = null)
  {
    if (isset($this->yamlConfig[$category][$keyName]))
    {
      return $this->yamlConfig[$category][$keyName];
    }
    else if (isset($this->yamlConfig['all'][$keyName]))
    {
      return $this->yamlConfig['all'][$keyName];
    }

    return $defaultValue;
  }
}
