<?php

class Event {
    private int $id;
    private int $idArtiste;
    private string $titre;
    private string $description;
    private string $dateEvenement;
    private string $ville;
    private string $lieu;

    public function __construct(
        ?int $id,
        int $idArtiste,
        string $titre,
        string $description,
        string $dateEvenement,
        string $ville,
        string $lieu
    ) {
        $this->id = $id;
        $this->idArtiste = $idArtiste;
        $this->titre = $titre;
        $this->description = $description;
        $this->dateEvenement = $dateEvenement;
        $this->ville = $ville;
        $this->lieu = $lieu;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getIdArtiste(): int {
        return $this->idArtiste;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getDateEvenement(): string {
        return $this->dateEvenement;
    }

    public function getVille(): string {
        return $this->ville;
    }

    public function getLieu(): string {
        return $this->lieu;
    }
}
