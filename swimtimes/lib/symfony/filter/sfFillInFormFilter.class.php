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
 * @subpackage filter
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfFillInFormFilter.class.php 2677 2006-11-14 12:17:20Z mike $
 */
class sfFillInFormFilter extends sfFilter
{
  public function execute($filterChain)
  {
    // execute next filter
    $filterChain->execute();

    $context  = $this->getContext();
    $response = $context->getResponse();
    $request  = $context->getRequest();

    $fillInForm = new sfFillInForm();

    // converters
    foreach ($this->getParameter('converters', array()) as $functionName => $fields)
    {
      $fillInForm->addConverter($functionName, $fields);
    }

    // skip fields
    $fillInForm->setSkipFields((array) $this->getParameter('skip_fields', array()));

    // types
    $excludeTypes = (array) $this->getParameter('exclude_types', array('hidden', 'password'));
    $checkTypes   = (array) $this->getParameter('check_types',   array('text', 'checkbox', 'radio', 'password', 'hidden'));
    $fillInForm->setTypes(array_diff($checkTypes, $excludeTypes));

    // fill in
    $content = $fillInForm->fillIn($response->getContent(), $this->getParameter('name'), $this->getParameter('id'), $request->getParameterHolder()->getAll());

    $response->setContent($content);
  }
}
