<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfDomCssSelector allows to navigate a DOM with CSS selector.
 *
 * based on getElementsBySelector version 0.4 - Simon Willison, March 25th 2003
 * http://simon.incutio.com/archive/2003/03/25/getElementsBySelector
 *
 * @package    symfony
 * @subpackage util
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfDomCssSelector.class.php 2867 2006-11-29 13:33:35Z fabien $
 */
class sfDomCssSelector
{
  protected $dom = null;

  public function __construct($dom)
  {
    $this->dom = $dom;
  }

  public function getTexts($selector)
  {
    $texts = array();
    foreach ($this->getElements($selector) as $element)
    {
      $texts[] = $element->nodeValue;
    }

    return $texts;
  }

  public function getElements($selector)
  {
    $all_nodes = array();
    foreach ($this->tokenize_selectors($selector) as $selector)
    {
      $nodes = array($this->dom);
      foreach ($this->tokenize($selector) as $token)
      {
        $combinator = $token['combinator'];
        $token = trim($token['name']);
        $pos = strpos($token, '#');
        if (false !== $pos && preg_match('/^[A-Za-z0-9]*$/', substr($token, 0, $pos)))
        {
          // Token is an ID selector
          $tagName = substr($token, 0, $pos);
          $id = substr($token, $pos + 1);
          $xpath = new DomXPath($this->dom);
          $element = $xpath->query(sprintf("//*[@id = '%s']", $id))->item(0);
          if (!$element || ($tagName && strtolower($element->nodeName) != $tagName))
          {
            // tag with that ID not found
            return array();
          }

          // Set nodes to contain just this element
          $nodes = array($element);

          continue; // Skip to next token
        }

        $pos = strpos($token, '.');
        if (false !== $pos && preg_match('/^[A-Za-z0-9]*$/', substr($token, 0, $pos)))
        {
          // Token contains a class selector
          $tagName = substr($token, 0, $pos);
          if (!$tagName)
          {
            $tagName = '*';
          }
          $className = substr($token, $pos + 1);

          // Get elements matching tag, filter them for class selector
          $founds = $this->getElementsByTagName($nodes, $tagName, $combinator);
          $nodes = array();
          foreach ($founds as $found)
          {
            if (preg_match('/\b'.$className.'\b/', $found->getAttribute('class')))
            {
              $nodes[] = $found;
            }
          }

          continue; // Skip to next token
        }

        // Code to deal with attribute selectors
        if (preg_match('/^(\w*)(\[.+\])$/', $token, $matches))
        {
          $tagName = $matches[1] ? $matches[1] : '*';
          preg_match_all('/
            \[
              (\w+)                 # attribute
              ([=~\|\^\$\*]?)       # modifier (optional)
              =?                    # equal (optional)
              (
                "([^"]*)"           # quoted value (optional)
                |
                ([^\]]*)            # non quoted value (optional)
              )
            \]
          /x', $matches[2], $matches, PREG_SET_ORDER);

          // Grab all of the tagName elements within current node
          $founds = $this->getElementsByTagName($nodes, $tagName, $combinator);
          $nodes = array();
          foreach ($founds as $found)
          {
            $ok = false;
            foreach ($matches as $match)
            {
              $attrName = $match[1];
              $attrOperator = $match[2];
              $attrValue = $match[4];

              switch ($attrOperator)
              {
                case '=': // Equality
                  $ok = $found->getAttribute($attrName) == $attrValue;
                  break;
                case '~': // Match one of space seperated words
                  $ok = preg_match('/\b'.preg_quote($attrValue, '/').'\b/', $found->getAttribute($attrName));
                  break;
                case '|': // Match start with value followed by optional hyphen
                  $ok = preg_match('/^'.preg_quote($attrValue, '/').'-?/', $found->getAttribute($attrName));
                  break;
                case '^': // Match starts with value
                  $ok = 0 === strpos($found->getAttribute($attrName), $attrValue);
                  break;
                case '$': // Match ends with value
                  $ok = $attrValue == substr($found->getAttribute($attrName), -strlen($attrValue));
                  break;
                case '*': // Match ends with value
                  $ok = false !== strpos($found->getAttribute($attrName), $attrValue);
                  break;
                default :
                  // Just test for existence of attribute
                  $ok = $found->hasAttribute($attrName);
              }

              if (false == $ok)
              {
                break;
              }
            }

            if ($ok)
            {
              $nodes[] = $found;
            }
          }

          continue; // Skip to next token
        }

        // If we get here, token is JUST an element (not a class or ID selector)
        $nodes = $this->getElementsByTagName($nodes, $token, $combinator);
      }

      foreach ($nodes as $node)
      {
        if (!$node->getAttribute('sf_matched'))
        {
          $node->setAttribute('sf_matched', true);
          $all_nodes[] = $node;
        }
      }
    }

    foreach ($all_nodes as $node)
    {
      $node->removeAttribute('sf_matched');
    }

    return $all_nodes;
  }

  protected function getElementsByTagName($nodes, $tagName, $combinator = ' ')
  {
    $founds = array();
    foreach ($nodes as $node)
    {
      switch ($combinator)
      {
        case ' ':
          foreach ($node->getElementsByTagName($tagName) as $element)
          {
            $founds[] = $element;
          }
          break;
        case '>':
          foreach ($node->childNodes as $element)
          {
            if ($tagName == $element->nodeName)
            {
              $founds[] = $element;
            }
          }
          break;
        case '+':
          $element = $node->childNodes->item(0);
          if ($tagName == $element->nodeName)
          {
            $founds[] = $element;
          }
          break;
      }
    }

    return $founds;
  }

  protected function tokenize_selectors($selector)
  {
    // split tokens by , except in an attribute selector
    $tokens = array();
    $quoted = false;
    $token = '';
    for ($i = 0, $max = strlen($selector); $i < $max; $i++)
    {
      if (',' == $selector[$i] && !$quoted)
      {
        $tokens[] = trim($token);
        $token = '';
      }
      else if ('"' == $selector[$i])
      {
        $token .= $selector[$i];
        $quoted = $quoted ? false : true;
      }
      else
      {
        $token .= $selector[$i];
      }
    }
    if ($token)
    {
      $tokens[] = trim($token);
    }

    return $tokens;
  }

  protected function tokenize($selector)
  {
    // split tokens by space except if space is in an attribute selector
    $tokens = array();
    $combinators = array(' ', '>', '+');
    $quoted = false;
    $token = array('combinator' => ' ', 'name' => '');
    for ($i = 0, $max = strlen($selector); $i < $max; $i++)
    {
      if (in_array($selector[$i], $combinators) && !$quoted)
      {
        // remove all whitespaces around the combinator
        $combinator = $selector[$i];
        while (in_array($selector[$i + 1], $combinators))
        {
          if (' ' != $selector[++$i])
          {
            $combinator = $selector[$i];
          }
        }

        $tokens[] = $token;
        $token = array('combinator' => $combinator, 'name' => '');
      }
      else if ('"' == $selector[$i])
      {
        $token['name'] .= $selector[$i];
        $quoted = $quoted ? false : true;
      }
      else
      {
        $token['name'] .= $selector[$i];
      }
    }
    if ($token['name'])
    {
      $tokens[] = $token;
    }

    return $tokens;
  }
}
