<?php

namespace App\Entity;

use App\Entity\Event\Type;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    const PRICE_TYPE_FIXED = 'visible';
    const PRICE_TYPE_MIN = 'min';

    const EUR_CURRENCY = 'EUR';
    const CHF_CURRENCY = 'CHF';

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
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Event\Type")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $priorKnowledge = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $coach = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $education = 0;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     */
    private $endDate;

    /**
     * @ORM\ManyToMany(targetEntity="EventTrainer", inversedBy="trainers", cascade={"persist"})
     */
    private $trainers;

    /**
     * @ORM\ManyToMany(targetEntity="StaffMember", inversedBy="staffMembers", cascade={"persist"})
     */
    private $staffMembers;

    /**
     * @ORM\ManyToOne(targetEntity="Location", cascade={"persist"})
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id", nullable=true)
     */
    private $location;

    /**
     * @ORM\Column(type="string")
     */
    private $priceType;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $price;

    /**
     * @ORM\Column(type="string")
     */
    private $currency;

    /**
     * @ORM\OneToMany(targetEntity="EventPhoto", mappedBy="event", cascade={"persist"})
     */
    private $photos;

    public function __construct()
    {
        $this->trainers = new ArrayCollection();
        $this->staffMembers = new ArrayCollection();
        $this->photos = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getPriorKnowledge()
    {
        return $this->priorKnowledge;
    }

    /**
     * @param int $priorKnowledge
     */
    public function setPriorKnowledge($priorKnowledge): void
    {
        $this->priorKnowledge = $priorKnowledge;
    }

    /**
     * @return int
     */
    public function getCoach()
    {
        return $this->coach;
    }

    /**
     * @param int $coach
     */
    public function setCoach($coach): void
    {
        $this->coach = $coach;
    }

    /**
     * @return int
     */
    public function getEducation(): int
    {
        return $this->education;
    }

    /**
     * @param int $education
     */
    public function setEducation($education): void
    {
        $this->education = $education;
    }

    /**
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param Type $type
     */
    public function setType(Type $type): void
    {
        $this->type = $type;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return ArrayCollection
     */
    public function getTrainers()
    {
        return $this->trainers;
    }

    /**
     * @param EventTrainer $trainer
     */
    public function addTrainer(EventTrainer $trainer)
    {
        $trainer->addEvent($this);
        $this->trainers[] = $trainer;
    }

    /**
     * @param $trainers
     */
    public function setTrainers($trainers)
    {
        $this->trainers = $trainers;
    }

    /**
     * @return ArrayCollection
     */
    public function getStaffMembers()
    {
        return $this->staffMembers;
    }

    /**
     * @param StaffMember $staff
     */
    public function addStaffMember(StaffMember $staff)
    {
        $staff->addEvent($this);
        $this->staffMembers[] = $staff;
    }

    /**
     * @param $staffMembers
     */
    public function setStaffMembers($staffMembers)
    {
        $this->staffMembers = $staffMembers;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location): void
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getPriceType()
    {
        return $this->priceType;
    }

    /**
     * @param $type
     */
    public function setPriceType($type)
    {
        if (!in_array($type, array(self::PRICE_TYPE_FIXED, self::PRICE_TYPE_MIN))) {
            throw new \InvalidArgumentException("Invalid price type");
        }
        $this->priceType = $type;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    public function getDisplayPrice()
    {
        return $this->price / 100;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency): void
    {
        if (!in_array($currency, array(self::EUR_CURRENCY, self::CHF_CURRENCY))) {
            throw new \InvalidArgumentException("Invalid price currency");
        }
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @param mixed $photos
     */
    public function setPhotos($photos): void
    {
        $this->photos = $photos;
    }

    public function addPhoto(EventPhoto $photo)
    {
        $photo->setEvent($this);
        $this->photos->add($photo);
    }

    public function removePhoto(EventPhoto $photo)
    {

    }

}