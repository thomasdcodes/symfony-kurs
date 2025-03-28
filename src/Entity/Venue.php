<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\VenueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(VenueRepository::class)]
class Venue
{
    use IdTrait;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50)]
    #[Groups(['appointment'])]
    private ?string $name = null;

    /**
     * @var Collection<int, Appointment>
     */
    #[ORM\OneToMany(targetEntity: Appointment::class, mappedBy: 'venue', orphanRemoval: true)]
    private Collection $appointments;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\GreaterThanOrEqual(0)]
    private ?int $numOfAdvancedGuards = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\GreaterThanOrEqual(0)]
    private ?int $numOfGuards = null;

    public function __construct()
    {
        $this->appointments = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(?string $name): Venue
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Collection<int, Appointment>
     */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    public function addAppointment(Appointment $appointment): static
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments->add($appointment);
            $appointment->setVenue($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): static
    {
        if ($this->appointments->removeElement($appointment)) {
            // set the owning side to null (unless already changed)
            if ($appointment->getVenue() === $this) {
                $appointment->setVenue(null);
            }
        }

        return $this;
    }

    public function getNumOfAdvancedGuards(): int
    {
        return $this->numOfAdvancedGuards;
    }

    public function setNumOfAdvancedGuards(int $numOfAdvancedGuards): static
    {
        $this->numOfAdvancedGuards = $numOfAdvancedGuards;

        return $this;
    }

    public function getNumOfGuards(): int
    {
        return $this->numOfGuards;
    }

    public function setNumOfGuards(int $numOfGuards): static
    {
        $this->numOfGuards = $numOfGuards;

        return $this;
    }
}