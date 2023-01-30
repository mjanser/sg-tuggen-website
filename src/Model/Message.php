<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

final class Message
{
    /**
     * @var string|null
     *
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string|null
     *
     * @Assert\NotBlank()
     *
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string|null
     *
     * @Assert\NotBlank()
     */
    private $subject;

    /**
     * @var string|null
     *
     * @Assert\NotBlank()
     */
    private $body;

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }
}
