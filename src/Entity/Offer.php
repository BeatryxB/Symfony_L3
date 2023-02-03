<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OfferRepository::class)
 */
class Offer
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
     * @ORM\Column(type="text")
     */
    private $introduceText;

    /**
     * @ORM\Column(type="text")
     */
    private $offerText;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=Souscription::class, mappedBy="Offer")
     */
    private $souscriptions;

    public function __construct()
    {
        $this->souscriptions = new ArrayCollection();
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

    public function getIntroduceText(): ?string
    {
        return $this->introduceText;
    }

    public function setIntroduceText(string $introduceText): self
    {
        $this->introduceText = $introduceText;

        return $this;
    }

    public function getOfferText(): ?string
    {
        return $this->offerText;
    }

    public function setOfferText(string $offerText): self
    {
        $this->offerText = $offerText;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Souscription[]
     */
    public function getSouscriptions(): Collection
    {
        return $this->souscriptions;
    }

    public function addSouscription(Souscription $souscription): self
    {
        if (!$this->souscriptions->contains($souscription)) {
            $this->souscriptions[] = $souscription;
            $souscription->setOffer($this);
        }

        return $this;
    }

    public function removeSouscription(Souscription $souscription): self
    {
        if ($this->souscriptions->contains($souscription)) {
            $this->souscriptions->removeElement($souscription);
            // set the owning side to null (unless already changed)
            if ($souscription->getOffer() === $this) {
                $souscription->setOffer(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->getTitle();
    }
}
