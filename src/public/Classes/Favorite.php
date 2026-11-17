<?php

class Favorite {
    private int $idUser;
    private int $idEvent;

    public function __construct(
        int $idUser,
        int $idEvent
    ) {
        $this->idUser = $idUser;
        $this->idEvent = $idEvent;
    }

    public function getIdUser(): int {
        return $this->idUser;
    }

    public function getIdEvent(): int {
        return $this->idEvent;
    }
}
