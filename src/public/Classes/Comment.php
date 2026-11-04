<?php

class Comment {
    private int $id;
    private int $idUser;
    private int $idEvent;
    private string $contenu;

    public function __construct(
        int $id,
        int $idUser,
        int $idEvent,
        string $contenu
    ) {
        $this->id = $id;
        $this->idUser = $idUser;
        $this->idEvent = $idEvent;
        $this->contenu = $contenu;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getIdUser(): int {
        return $this->idUser;
    }

    public function getIdEvent(): int {
        return $this->idEvent;
    }

    public function getContenu(): string {
        return $this->contenu;
    }
}
