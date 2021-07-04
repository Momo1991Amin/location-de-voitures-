<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PrePersist;
use App\Repository\BookingRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Booking 
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Type("\DateTimeInterface",message="veuillez rentrer un date valide")
     * @Assert\GreaterThan("today", message="La date d'arriver doit être ultérieure à la date d'aujourd'hui !")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Type("\DateTimeInterface",message="veuillez rentrer un date valide")
     * @Assert\GreaterThan(propertyPath="startDate", message="La date de départ doit être plus éloigner que la date d'arriver")
     * 
     */
    private $endDate;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $booker;

    /**
     * @ORM\ManyToOne(targetEntity=Car::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $car;

    /**
     * Callback Permet d'initialiser une date et un montant total au moment de presister dans la bdd
     * 
     * @ORM\PrePersist
     *
     */
    public function prepersist()
    {
        if(empty($this->createdAt)) {
            $this->createdAt = new \DateTime();
        }

        if(empty($this->amount)) {
            $this->amount = $this->car->getPrice() * $this->getDays();
        }
    }

    /**
     * Permet de vérifier la disponibilité d'un véhicule
     *
     * @return boolean
     */
    public function isbookableDates() 
    {
        $notAvailableDay = $this->car->getNotAvailableDays();
        $daybook         = $this->getDaysBooking();

        $formatday = function($day){
            return $day->format('y-m-d');
        };

        $notAvailableDay = array_map($formatday,$notAvailableDay);
        $daybook         = array_map($formatday,$daybook);

        foreach($daybook as $day){
            if(in_array($day,$notAvailableDay)){
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     * Permet de récupérer les jours de la réservation sous forme de journée DateTime(y-m-d)
     *
     * @return array
     */
    public function getDaysBooking()
    {
        $result = range(
            $this->startDate->getTimestamp(),
            $this->endDate->getTimestamp(),
            24 * 60 *60
        );

        $day = array_map(function($timestamp){
            return new \DateTime(date('y-m-d',$timestamp));
        },$result);

        return $day;
    }

    /**
     * Calcule les jours entre la date d'arriver et la date de départ
     *
     * @return void
     */
    public function getDays()
    {
        $diff = $this->endDate->diff($this->startDate);
        return $diff->days;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getBooker(): ?User
    {
        return $this->booker;
    }

    public function setBooker(?User $booker): self
    {
        $this->booker = $booker;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }
}
