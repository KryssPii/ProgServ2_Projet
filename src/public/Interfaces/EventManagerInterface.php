<?php

interface EventManagerInterface {
    public function add(Event $event): int;

    public function getById(int $id): ?Event;

    /** @return Event[] */
    public function getAll(): array;

    public function update(Event $event): bool;

    public function remove(int $id): bool;
}
