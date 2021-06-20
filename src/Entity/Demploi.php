<?php

namespace App\Entity;

use App\Entity\Condidat;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DemploiRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=DemploiRepository::class)
 */
class Demploi
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
     * @ORM\ManyToOne(targetEntity=Oemploi::class, inversedBy="idDemploi")
     */
    private $oemploi;

    /**
     * @ORM\OneToMany(targetEntity=Rdv::class, mappedBy="demploi" , cascade={"remove"})
     */
    private $idRdv;

    /**
     * @ORM\ManyToOne(targetEntity=Condidat::class, inversedBy="demplois")
     */
    private $idcondidat;

    public function __construct()
    {
        $this->idRdv = new ArrayCollection();
    }

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

    public function getOemploi(): ?Oemploi
    {
        return $this->oemploi;
    }

    public function setOemploi(?Oemploi $oemploi): self
    {
        $this->oemploi = $oemploi;

        return $this;
    }

    /**
     * @return Collection|Rdv[]
     */
    public function getIdRdv(): Collection
    {
        return $this->idRdv;
    }

    public function addIdRdv(Rdv $idRdv): self
    {
        if (!$this->idRdv->contains($idRdv)) {
            $this->idRdv[] = $idRdv;
            $idRdv->setDemploi($this);
        }

        return $this;
    }

    public function removeIdRdv(Rdv $idRdv): self
    {
        if ($this->idRdv->removeElement($idRdv)) {
            // set the owning side to null (unless already changed)
            if ($idRdv->getDemploi() === $this) {
                $idRdv->setDemploi(null);
            }
        }

        return $this;
    }

    public function getIdcondidat(): ?Condidat
    {
        return $this->idcondidat;
    }

    public function setIdcondidat(?Condidat $idcondidat): self
    {
        $this->idcondidat = $idcondidat;

        return $this;
    }
    public function __toString(){
        $mobile = $this->getIdcondidat()->getMobile();
        $nomdemploi = $this->getOemploi()->getTitle();
        $etat = $this->getEtat();
        return $mobile." :" . $nomdemploi." Status : ".$etat;
    }
}
