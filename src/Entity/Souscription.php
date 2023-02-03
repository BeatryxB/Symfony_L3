<?php

namespace App\Entity;

use App\Repository\SouscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SouscriptionRepository::class)
 */
class Souscription
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Souscription")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Offer::class, inversedBy="souscriptions")
     */
    private $Offer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getOffer(): ?Offer
    {
        return $this->Offer;
    }

    public function setOffer(?Offer $Offer): self
    {
        $this->Offer = $Offer;

        return $this;
    }

    public function __construct(?User $user,?Offer $Offer){
        $this->setEtat(1);
    }
}
