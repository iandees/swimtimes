<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfSessionTestStorage is a fake sfSessionStorage implementation to allow easy testing.
 *
 * @package    symfony
 * @subpackage storage
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfSessionTestStorage.class.php 2747 2006-11-17 19:37:11Z fabien $
 */
class sfSessionTestStorage extends sfStorage
{
  protected
    $sessionId   = null,
    $sessionData = array(),
    $sessionPath = null;

  /**
   * Initialize this Storage.
   *
   * @param sfContext A sfContext instance.
   * @param array   An associative array of initialization parameters.
   *
   * @return bool true, if initialization completes successfully, otherwise false.
   *
   * @throws <b>sfInitializationException</b> If an error occurs while initializing this Storage.
   */
  public function initialize ($context, $parameters = null)
  {
    // initialize parent
    parent::initialize($context, $parameters);

    $this->sessionPath = sfConfig::get('sf_test_cache_dir').DIRECTORY_SEPARATOR.'sessions';

    if (array_key_exists('session_id', $_SERVER))
    {
      $this->sessionId = $_SERVER['session_id'];

      // we read session data from temp file
      $file = $this->sessionPath.DIRECTORY_SEPARATOR.$this->sessionId.'.session';
      $this->sessionData = file_exists($file) ? unserialize(file_get_contents($file)) : array();
    }
    else
    {
      $this->sessionId   = md5(uniqid(rand(), true));
      $this->sessionData = array();
    }
  }

  public function getSessionId()
  {
    return $this->sessionId;
  }

  /**
   * Read data from this storage.
   *
   * The preferred format for a key is directory style so naming conflicts can be avoided.
   *
   * @param string A unique key identifying your data.
   *
   * @return mixed Data associated with the key.
   */
  public function & read ($key)
  {
    $retval = null;

    if (isset($this->sessionData[$key]))
    {
      $retval =& $this->sessionData[$key];
    }

    return $retval;
  }

  /**
   * Remove data from this storage.
   *
   * The preferred format for a key is directory style so naming conflicts can be avoided.
   *
   * @param string A unique key identifying your data.
   *
   * @return mixed Data associated with the key.
   */
  public function & remove ($key)
  {
    $retval = null;

    if (isset($this->sessionData[$key]))
    {
      $retval =& $this->sessionData[$key];
      unset($this->sessionData[$key]);
    }

    return $retval;
  }

  /**
   * Execute the shutdown procedure.
   *
   * @return void
   */
  public function shutdown ()
  {
    if ($this->sessionId)
    {
      $current_umask = umask(0000);
      if (!is_dir($this->sessionPath))
      {
        mkdir($this->sessionPath, 0777, true);
      }
      umask($current_umask);
      file_put_contents($this->sessionPath.DIRECTORY_SEPARATOR.$this->sessionId.'.session', serialize($this->sessionData));
      $this->sessionId   = '';
      $this->sessionData = array();
    }
  }

  /**
   * Write data to this storage.
   *
   * The preferred format for a key is directory style so naming conflicts can
   * be avoided.
   *
   * @param string A unique key identifying your data.
   * @param mixed  Data associated with your key.
   *
   * @return void
   */
  public function write ($key, &$data)
  {
    $this->sessionData[$key] =& $data;
  }

  /**
   * Clear all test sessions
   */
  public function clear ()
  {
    sfToolkit::clearDirectory($this->sessionPath);
  }
}
