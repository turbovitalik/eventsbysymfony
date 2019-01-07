<?php

namespace App\Entity;

use App\Entity\Event\Type;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
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
}