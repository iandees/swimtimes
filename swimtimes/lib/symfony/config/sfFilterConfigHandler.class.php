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
 * sfFilterConfigHandler allows you to register filters with the system.
 *
 * @package    symfony
 * @subpackage config
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author     Sean Kerr <skerr@mojavi.org>
 * @version    SVN: $Id: sfFilterConfigHandler.class.php 2661 2006-11-13 10:43:43Z fabien $
 */
class sfFilterConfigHandler extends sfYamlConfigHandler
{
  /**
   * Execute this configuration handler.
   *
   * @param array An array of absolute filesystem path to a configuration file.
   *
   * @return string Data to be written to a cache file.
   *
   * @throws sfConfigurationException If a requested configuration file does not exist or is not readable.
   * @throws sfParseException If a requested configuration file is improperly formatted.
   */
  public function execute($configFiles)
  {
    // parse the yaml
    $config = $this->parseYaml($configFiles[0]);
    foreach (array_slice($configFiles, 1) as $i => $configFile)
    {
      // we get the order of the new file and merge with the previous configurations
      $previous = $config;

      $config = array();
      foreach ($this->parseYaml($configFile) as $key => $value)
      {
        $value = (array) $value;
        $config[$key] = isset($previous[$key]) ? sfToolkit::arrayDeepMerge($previous[$key], $value) : $value;
      }

      // check that every key in previous array is still present (to avoid problem when upgrading)
      foreach (array_keys($previous) as $key)
      {
        if (!isset($config[$key]))
        {
          throw new sfConfigurationException(sprintf('The filter name "%s" is defined in "%s" but not present in "%s" file. To disable a filter, add a "enabled" key with a false value', $key, $configFiles[$i], $configFile));
        }
      }
    }

    // init our data and includes arrays
    $data     = array();
    $includes = array();

    $execution = false;
    $rendering = false;

    // let's do our fancy work
    foreach ($config as $category => $keys)
    {
      if (isset($keys['enabled']) && !$keys['enabled'])
      {
        continue;
      }

      if (!isset($keys['class']))
      {
        // missing class key
        $error = 'Configuration file "%s" specifies category "%s" with missing class key';
        $error = sprintf($error, $configFiles[0], $category);

        throw new sfParseException($error);
      }

      $class = $keys['class'];

      if (isset($keys['file']))
      {
        // we have a file to include
        $file = $this->replaceConstants($keys['file']);
        $file = $this->replacePath($file);

        if (!is_readable($file))
        {
          // filter file doesn't exist
          $error = sprintf('Configuration file "%s" specifies class "%s" with nonexistent or unreadable file "%s"', $configFiles[0], $class, $file);

          throw new sfParseException($error);
        }

        // append our data
        $includes[] = sprintf("require_once('%s');\n", $file);
      }

      $condition = true;
      if (isset($keys['param']['condition']))
      {
        $condition = $this->replaceConstants($keys['param']['condition']);
        unset($keys['param']['condition']);
      }

      $type = isset($keys['param']['type']) ? $keys['param']['type'] : null;
      unset($keys['param']['type']);

      // parse parameters
      $parameters = isset($keys['param']) ? var_export($keys['param'], true) : 'null';

      if ($condition)
      {
        // append new data
        if ('security' == $type)
        {
          $data[] = $this->addSecurityFilter($category, $class, $parameters);
        }
        else
        {
          $data[] = $this->addFilter($category, $class, $parameters);
        }

        if ('rendering' == $type)
        {
          $rendering = true;
        }

        if ('execution' == $type)
        {
          $execution = true;
        }
      }
    }

    if (!$rendering)
    {
      $error = sprintf('Configuration file "%s" must register a filter of type "rendering"', $configFiles[0]);

      throw new sfParseException($error);
    }

    if (!$execution)
    {
      $error = sprintf('Configuration file "%s" must register a filter of type "execution"', $configFiles[0]);

      throw new sfParseException($error);
    }

    // compile data
    $retval = sprintf("<?php\n".
                      "// auto-generated by sfFilterConfigHandler\n".
                      "// date: %s%s\n%s\n\n", date('Y/m/d H:i:s'),
                      implode("\n", $includes), implode("\n", $data));

    return $retval;
  }

  protected function addFilter($category, $class, $parameters)
  {
    return sprintf("\nlist(\$class, \$parameters) = (array) sfConfig::get('sf_%s_filter', array('%s', %s));\n".
                      "\$filter = new \$class();\n".
                      "\$filter->initialize(\$this->context, \$parameters);\n".
                      "\$filterChain->register(\$filter);",
                      $category, $class, $parameters);
  }

  protected function addSecurityFilter($category, $class, $parameters)
  {
    return <<<EOF

// does this action require security?
if (\$actionInstance->isSecure())
{
  if (!in_array('sfSecurityUser', class_implements(\$this->context->getUser())))
  {
    \$error = 'Security is enabled, but your sfUser implementation does not implement sfSecurityUser interface';
    throw new sfSecurityException(\$error);
  }
  {$this->addFilter($category, $class, $parameters)}
}
EOF;
  }
}
