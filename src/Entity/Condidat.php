<?php

namespace App\Entity;

use App\Repository\CondidatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CondidatRepository::class)
 */
class Condidat extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $cvimage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $ddnaissance;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @ORM\OneToMany(targetEntity=Demploi::class, mappedBy="idcondidat")
     */
    private $demplois;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tentative;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $lastattempt;

    public function __construct()
    {
        $this->demplois = new ArrayCollection();
    }

    public function _construct(){
        $this->roles = ['ROLE_CONDIDAT'];
        $this->enabled = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCvimage()
    {
        return $this->cvimage;
    }

    public function setCvimage($cvimage)
    {
        $this->cvimage = $cvimage;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDdnaissance(): ?\DateTimeInterface
    {
        return $this->ddnaissance;
    }

    public function setDdnaissance(\DateTimeInterface $ddnaissance): self
    {
        $this->ddnaissance = $ddnaissance;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return Collection|Demploi[]
     */
    public function getDemplois(): Collection
    {
        return $this->demplois;
    }

    public function addDemploi(Demploi $demploi): self
    {
        if (!$this->demplois->contains($demploi)) {
            $this->demplois[] = $demploi;
            $demploi->setIdcondidat($this);
        }

        return $this;
    }

    public function removeDemploi(Demploi $demploi): self
    {
        if ($this->demplois->removeElement($demploi)) {
            // set the owning side to null (unless already changed)
            if ($demploi->getIdcondidat() === $this) {
                $demploi->setIdcondidat(null);
            }
        }

        return $this;
    }
    public function __toString(){
        $nomprenom = $this->nom ." ". $this->prenom . " : " . $this->getEmail() . "-- : " . $this->getMobile();
        return $nomprenom;
    }

    public function getTentative(): ?int
    {
        return $this->tentative;
    }

    public function setTentative(?int $tentative): self
    {
        $this->tentative = $tentative;

        return $this;
    }

    public function getLastattempt(): ?\DateTimeInterface
    {
        return $this->lastattempt;
    }

    public function setLastattempt($lastattempt): self
    {
        $this->lastattempt = $lastattempt;

        return $this;
    }


}
