<?php

/*
 * This file is part of the SgTuggen\ContactBundle
 *
 * (c) Martin Janser <martin@gogan.ch>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SgTuggen\ContactBundle\Model;

interface MessageInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     *
     * @return MessageInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     *
     * @return MessageInterface
     */
    public function setEmail($email);

    /**
     * Set the sender information
     *
     * @param string $name
     * @param string $email
     *
     * @return MessageInterface
     */
    public function setSender($name, $email);

    /**
     * @return string
     */
    public function getSubject();

    /**
     * @param string $subject
     *
     * @return MessageInterface
     */
    public function setSubject($subject);

    /**
     * @return string
     */
    public function getBody();

    /**
     * @param string $body
     *
     * @return MessageInterface
     */
    public function setBody($body);
}
