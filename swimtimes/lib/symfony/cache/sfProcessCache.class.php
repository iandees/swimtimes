<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage cache
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id$
 */
class sfProcessCache
{
  public static function cacher()
  {
    static $cacher = null;

    if (null === $cacher)
    {
      if (!sfConfig::get('sf_use_process_cache'))
      {
        $cacher = false;
      }
      elseif (function_exists('apc_store'))
      {
        $cacher = 'apc';
      }
      elseif (function_exists('xcache_set'))
      {
        $cacher = 'xcache';
      }
      elseif (function_exists('ecacher_put'))
      {
        $cacher = 'eaccelerator';
      }
      else
      {
        $cacher = false;
      }
    }

    return $cacher;
  }

  public static function set($name, $value, $lifeTime = 0)
  {
    switch (self::cacher())
    {
      case 'apc':
        return apc_store($name, $value, $lifeTime);
      case 'xcache':
        return xcache_set($name, $value, $lifeTime);
      case 'eaccelerator':
        return eaccelerator_put($name, serialize($value), $lifeTime);
    }

    return false;
  }

  public static function get($name)
  {
    switch (self::cacher())
    {
      case 'apc':
        $value = apc_fetch($name);
        return false === $value ? null : $value;
      case 'xcache':
        return xcache_isset($name) ? xcache_get($name) : null;
      case 'eaccelerator':
        return unserialize(eaccelerator_get($name));
    }

    return null;
  }

  public static function has($name)
  {
    switch (self::cacher())
    {
      case 'apc':
        return false === apc_fetch($name) ? false : true;
      case 'xcache':
        return xcache_isset($name);
      case 'eaccelerator':
        return null === eaccelerator_get($name) ? false : true;
    }

    return false;
  }

  public static function clear()
  {
    switch (self::cacher())
    {
      case 'apc':
        return apc_clear_cache('user');
      case 'xcache':
        for ($i = 0, $max = xcache_count(XC_TYPE_VAR); $i < $max; $i++)
        {
          if (!xcache_clear_cache(XC_TYPE_VAR, $i))
          {
            return false;
          }
        }
        return true;
      case 'eaccelerator':
        eaccelerator_clean();
    }

    return false;
  }
}
