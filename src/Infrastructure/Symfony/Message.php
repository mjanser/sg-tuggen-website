<?php

declare(strict_types=1);

namespace Infrastructure\Symfony;

use Symfony\Component\Validator\Constraints as Assert;

final class Message
{
    #[Assert\NotBlank]
    private ?string $name = null;

    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email = null;

    #[Assert\NotBlank]
    private ?string $subject = null;

    #[Assert\NotBlank]
    private ?string $body = null;

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
