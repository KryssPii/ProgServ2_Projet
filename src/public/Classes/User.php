<?php

class User {
    private int $id;
    private string $pseudo;
    private string $email;
    private string $passwordHash;
    private string $role;
    private ?string $bio;

    public function __construct(
        ?int $id,
        string $pseudo,
        string $email,
        string $passwordHash,
        string $role,
        ?string $bio
    ) {
        $this->id = $id;
        $this->pseudo = $pseudo;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->role = $role;
        $this->bio = $bio;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getPseudo(): string {
        return $this->pseudo;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPasswordHash(): string {
        return $this->passwordHash;
    }

    public function getRole(): string {
        return $this->role;
    }

    public function getBio(): ?string {
        return $this->bio;
    }
}
