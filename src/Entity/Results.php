<?php

namespace App\Entity;

use App\Repository\ResultsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResultsRepository::class)
 */
class Results
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="results")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Quiz::class, inversedBy="results")
     */
    private $quiz;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $startdate;

    /**
     * @ORM\Column(type="dateinterval", nullable=true)
     */
    private $time_complete;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $count_curr_answ;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }

    public function getStartdate(): ?\DateTimeInterface
    {
        return $this->startdate;
    }

    public function setStartdate(?\DateTimeInterface $startdate): self
    {
        $this->startdate = $startdate;

        return $this;
    }

    public function getTimeComplete(): ?\DateInterval
    {
        return $this->time_complete;
    }

    public function setTimeComplete(?\DateInterval $time_complete): self
    {
        $this->time_complete = $time_complete;

        return $this;
    }

    public function getCountCurrAnsw(): ?int
    {
        return $this->count_curr_answ;
    }

    public function setCountCurrAnsw(?int $count_curr_answ): self
    {
        $this->count_curr_answ = $count_curr_answ;

        return $this;
    }
}
