<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 */
class Admin extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $moderator;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $full;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModerator(): ?bool
    {
        return $this->moderator;
    }

    public function setModerator(?bool $moderator): self
    {
        $this->moderator = $moderator;

        return $this;
    }

    public function getFull(): ?bool
    {
        return $this->full;
    }

    public function setFull(bool $full): self
    {
        $this->full = $full;

        return $this;
    }
}
