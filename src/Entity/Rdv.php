<?php

namespace App\Entity;

use App\Repository\RdvRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RdvRepository::class)
 */
class Rdv
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Demploi::class, inversedBy="idRdv")
     */
    private $demploi;

    /**
     * @ORM\ManyToOne(targetEntity=Recruiter::class, inversedBy="rdvs")
     */
    private $recruiteur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDemploi(): ?Demploi
    {

        return $this->demploi;
    }

    public function setDemploi(?Demploi $demploi): self
    {
        $this->demploi = $demploi;

        return $this;
    }

    public function getRecruiteur(): ?Recruiter
    {
        return $this->recruiteur;
    }

    public function setRecruiteur(?Recruiter $recruiteur): self
    {
        $this->recruiteur = $recruiteur;

        return $this;
    }
}
