<?php

namespace App\Models;

class User {

    private ?int $id;
    private string $name;
    private string $email;

    /**
     * @param string $name
     * @param string $email
     * @param ?int $id
     */
    public function __construct(?int $id, string $name, string $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;

    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

}