<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=AdsRepository::class)
 */
class Ads
{

    const CHARGES =[
        1 => '(Eau + Électricité)',
        2 => '(Eau)',
        3 => '(Électricité)',
        4 => 'Sans Charge'
    ];

    // const TITRE =[
    //     1 => 'Je libère une maison, j\'en cherche une autre',
    //     2 => 'Cherche (maison, chambre, studio, appartement) à louer',
    //     3 => 'Cherche (maison, chambre, studio, appartement) en vente'
    // ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=8, max=100)
     */
    private $titre;

    /**
     * @ORM\Column(type="text", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $charges;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $releaseDate;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $status = false;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ads")
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="ads")
     */
    private $categories;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="annonces", orphanRemoval=true, cascade={"persist"})
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->title);
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCharges(): ?string
    {
        return $this->charges;
    }

    public function setCharges(string $charges): self
    {
        $this->charges = $charges;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    // /**
    //  * @return Collection|Picture[]
    //  */
    // public function getPictures(): Collection
    // {
    //     return $this->pictures;
    // }

    //  public function getPicture(): ?Picture
    // {
    //     if ($this->pictures->isEmpty()) {
    //         return null;
    //     }
    //     return $this->pictures->first();
    // }

    // public function addPicture(Picture $picture): self
    // {
    //     if (!$this->pictures->contains($picture)) {
    //         $this->pictures[] = $picture;
    //         $picture->setAds($this);
    //     }

    //     return $this;
    // }

    // public function removePicture(Picture $picture): self
    // {
    //     if ($this->pictures->contains($picture)) {
    //         $this->pictures->removeElement($picture);
    //         // set the owning side to null (unless already changed)
    //         if ($picture->getAds() === $this) {
    //             $picture->setAds(null);
    //         }
    //     }

    //     return $this;
    // }


    // /**
    //  * @return mixed
    //  */ 
    // public function getPictureFiles()
    // {
    //     return $this->pictureFiles;
    // }

    // /**
    //  * @param mixed $pictureFiles
    //  * @return  self
    //  */ 
    // public function setPictureFiles($pictureFiles): self
    // {
    //     foreach ($pictureFiles as $pictureFile) {
    //         $picture = new Picture();
    //         $picture->setImageFile($pictureFile);
    //         $this->addPicture($picture);
    //     }
    //     $this->pictureFiles = $pictureFiles;

    //     return $this;
    // }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(?\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getCategories(): ?Category
    {
        return $this->categories;
    }

    public function setCategories(?Category $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setAnnonces($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getAnnonces() === $this) {
                $image->setAnnonces(null);
            }
        }

        return $this;
    }
}
