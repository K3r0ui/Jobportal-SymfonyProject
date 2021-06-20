<?php

namespace App\Entity;

use App\Repository\ParametreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParametreRepository::class)
 */
class Parametre
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $nom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $attempts;

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function getAttempts(): ?int
    {
        return $this->attempts;
    }

    public function setAttempts(?int $attempts): self
    {
        $this->attempts = $attempts;

        return $this;
    }
}
