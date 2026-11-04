<?php

interface UserManagerInterface {
    public function add(User $user): int;

    public function getById(int $id): ?User;

    public function getByEmail(string $email): ?User;

    /** @return User[] */
    public function getAll(): array;

    public function update(User $user): bool;

    public function remove(int $id): bool;
}
