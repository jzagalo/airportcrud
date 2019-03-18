<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AirportsRepository")
 */
class Airports
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $airlines;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Airline", mappedBy="airports")
     */
    private $airliners;

    public function __construct()
    {
        $this->airliners = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

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

    public function getAirlines(): ?string
    {
        return $this->airlines;
    }

    public function setAirlines(string $airlines): self
    {
        $this->airlines = $airlines;

        return $this;
    }

    /**
     * @return Collection|Airline[]
     */
    public function getAirliners(): Collection
    {
        return $this->airliners;
    }

    public function addAirliner(Airline $airliner): self
    {
        if (!$this->airliners->contains($airliner)) {
            $this->airliners[] = $airliner;
            $airliner->setAirports($this);
        }

        return $this;
    }

    public function removeAirliner(Airline $airliner): self
    {
        if ($this->airliners->contains($airliner)) {
            $this->airliners->removeElement($airliner);
            // set the owning side to null (unless already changed)
            if ($airliner->getAirports() === $this) {
                $airliner->setAirports(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->airlines;
    }
}
