<?php

interface FavoriteManagerInterface {
    public function add(Favorite $favorite): bool;

    public function exists(int $idUser, int $idEvent): bool;

    /** @return Favorite[] */
    public function getByUser(int $idUser): array;

    public function remove(int $idUser, int $idEvent): bool;
}
