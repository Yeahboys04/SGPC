<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cautionaryadvice
 *
 * @ORM\Table(name="cautionaryadvice", uniqueConstraints={@ORM\UniqueConstraint(name="id_cautionaryAdvice", columns={"id_cautionaryAdvice"})})
 * @ORM\Entity
 */
class Cautionaryadvice
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_cautionaryAdvice", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCautionaryadvice;

    /**
     * @var string
     *
     * @ORM\Column(name="name_cautionaryAdvice", type="string", length=50, nullable=false)
     */
    private $nameCautionaryadvice;

    /**
     * @var string
     *
     * @ORM\Column(name="sentenceCautionaryAdvice", type="string", length=500, nullable=false)
     */
    private $sentencecautionaryadvice;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Chimicalproduct", mappedBy="idCautionaryadvice")
     */
    private $idChimicalproduct;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idChimicalproduct = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdCautionaryadvice(): ?string
    {
        return $this->idCautionaryadvice;
    }

    public function getNameCautionaryadvice(): ?string
    {
        return $this->nameCautionaryadvice;
    }

    public function setNameCautionaryadvice(string $nameCautionaryadvice): self
    {
        $this->nameCautionaryadvice = $nameCautionaryadvice;

        return $this;
    }

    public function getSentencecautionaryadvice(): ?string
    {
        return $this->sentencecautionaryadvice;
    }

    public function setSentencecautionaryadvice(string $sentencecautionaryadvice): self
    {
        $this->sentencecautionaryadvice = $sentencecautionaryadvice;

        return $this;
    }

    /**
     * @return Collection|Chimicalproduct[]
     */
    public function getIdChimicalproduct(): Collection
    {
        return $this->idChimicalproduct;
    }

    public function addIdChimicalproduct(Chimicalproduct $idChimicalproduct): self
    {
        if (!$this->idChimicalproduct->contains($idChimicalproduct)) {
            $this->idChimicalproduct[] = $idChimicalproduct;
            $idChimicalproduct->addIdCautionaryadvice($this);
        }

        return $this;
    }

    public function removeIdChimicalproduct(Chimicalproduct $idChimicalproduct): self
    {
        if ($this->idChimicalproduct->contains($idChimicalproduct)) {
            $this->idChimicalproduct->removeElement($idChimicalproduct);
            $idChimicalproduct->removeIdCautionaryadvice($this);
        }

        return $this;
    }

}
