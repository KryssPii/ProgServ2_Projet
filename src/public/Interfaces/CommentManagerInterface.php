<?php

interface CommentManagerInterface {
    public function add(Comment $comment): int;

    public function getById(int $id): ?Comment;

    /** @return Comment[] */
    public function getByEvent(int $idEvent): array;

    public function update(Comment $comment): bool;

    public function remove(int $id): bool;
}
