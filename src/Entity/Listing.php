<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ListingRepository")
 */
class Listing
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ListingImage", mappedBy="Listing")
     */
    private $listingImages;

    public function __construct()
    {
        $this->listingImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
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

    /**
     * @return Collection|ListingImage[]
     */
    public function getListingImages(): Collection
    {
        return $this->listingImages;
    }

    public function addListingImage(ListingImage $listingImage): self
    {
        if (!$this->listingImages->contains($listingImage)) {
            $this->listingImages[] = $listingImage;
            $listingImage->setListing($this);
        }

        return $this;
    }

    public function removeListingImage(ListingImage $listingImage): self
    {
        if ($this->listingImages->contains($listingImage)) {
            $this->listingImages->removeElement($listingImage);
            // set the owning side to null (unless already changed)
            if ($listingImage->getListing() === $this) {
                $listingImage->setListing(null);
            }
        }

        return $this;
    }
}
