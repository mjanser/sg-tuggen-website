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
 * Exception when validation errors occur in handler
 */
class HandlerValidationException extends \RuntimeException implements ExceptionInterface
{
}
