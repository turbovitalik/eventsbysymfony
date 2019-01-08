<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Location
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     * @Assert\Length(max = 80)
     * @Assert\NotBlank
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     */
    private $place;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $streetAddress;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $extraInfo;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param mixed $place
     */
    public function setPlace($place): void
    {
        $this->place = $place;
    }

    /**
     * @return mixed
     */
    public function getStreetAddress()
    {
        return $this->streetAddress;
    }

    /**
     * @param mixed $streetAddress
     */
    public function setStreetAddress($streetAddress): void
    {
        $this->streetAddress = $streetAddress;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param mixed $website
     */
    public function setWebsite($website): void
    {
        $this->website = $website;
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param mixed $postalCode
     */
    public function setPostalCode($postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return mixed
     */
    public function getExtraInfo()
    {
        return $this->extraInfo;
    }

    /**
     * @param mixed $extraInfo
     */
    public function setExtraInfo($extraInfo): void
    {
        $this->extraInfo = $extraInfo;
    }
}