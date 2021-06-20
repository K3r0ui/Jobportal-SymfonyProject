<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\OemploiRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass=OemploiRepository::class)
 * @Vich\Uploadable
 */
class Oemploi
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $salaire;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="idCategorie")
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Demploi::class, mappedBy="oemploi")
     */
    private $idDemploi;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="array")
     */
    private $etat = ['full-time','part-time','internship','temporary','freelance'];

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $nomemployeur;

    /**
     * @ORM\Column(type="array")
     */
    private $emploirequirement = [];

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $employeurimage;
    /**
     * @Vich\UploadableField(mapping="employeurimage", fileNameProperty="employeurimage")
     * @var File
     */
    private $imageFile;

       /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $createdAt;

    // ...

    


    public function __construct()
    {
        $this->idDemploi = new ArrayCollection();
    }

    public function setImageFile(File $employeurimage = null)
    {
        $this->imageFile = $employeurimage;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($employeurimage) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSalaire(): ?float
    {
        return $this->salaire;
    }

    public function setSalaire(float $salaire): self
    {
        $this->salaire = $salaire;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|Demploi[]
     */
    public function getIdDemploi(): Collection
    {
        return $this->idDemploi;
    }

    public function addIdDemploi(Demploi $idDemploi): self
    {
        if (!$this->idDemploi->contains($idDemploi)) {
            $this->idDemploi[] = $idDemploi;
            $idDemploi->setOemploi($this);
        }

        return $this;
    }

    public function removeIdDemploi(Demploi $idDemploi): self
    {
        if ($this->idDemploi->removeElement($idDemploi)) {
            // set the owning side to null (unless already changed)
            if ($idDemploi->getOemploi() === $this) {
                $idDemploi->setOemploi(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->title;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getEtat(): ?array
    {
        return $this->etat;
    }

    public function setEtat(array $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getNomemployeur(): ?string
    {
        return $this->nomemployeur;
    }

    public function setNomemployeur(string $nomemployeur): self
    {
        $this->nomemployeur = $nomemployeur;

        return $this;
    }

    public function getEmploirequirement(): ?array
    {
        return $this->emploirequirement;
    }

    public function setEmploirequirement(array $emploirequirement): self
    {
        $this->emploirequirement = $emploirequirement;

        return $this;
    }

    public function getEmployeurimage(): ?string
    {
        return $this->employeurimage;
    }

    public function setEmployeurimage(string $employeurimage): self
    {
        $this->employeurimage = $employeurimage;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
