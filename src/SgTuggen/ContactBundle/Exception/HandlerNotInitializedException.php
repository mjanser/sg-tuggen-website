<?php

/*
 * This file is part of the SgTuggen\ContactBundle
 *
 * (c) Martin Janser <martin@gogan.ch>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SgTuggen\ContactBundle\Exception;

use SgTuggen\ContactBundle\Exception\ExceptionInterface;

/**
 * Exception when handler class was not correctly initialized
 */
class HandlerNotInitializedException extends \LogicException implements ExceptionInterface
{
}
