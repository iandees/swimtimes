<?php
// auto-generated by sfPhpConfigHandler
// date: 2006/12/16 12:44:04
ini_set('magic_quotes_runtime', '');
ini_set('log_errors', '1');
ini_set('arg_separator.output', '&amp;');
if (ini_get('magic_quotes_gpc') != false)
{
  sfLogger::getInstance()->warning('{sfPhpConfigHandler} php.ini "magic_quotes_gpc" key is better set to "false" (current value is "\'\'" - php.ini location: "/etc/php5/cgi/php.ini")');
}

if (ini_get('register_globals') != false)
{
  sfLogger::getInstance()->warning('{sfPhpConfigHandler} php.ini "register_globals" key is better set to "false" (current value is "\'\'" - php.ini location: "/etc/php5/cgi/php.ini")');
}

