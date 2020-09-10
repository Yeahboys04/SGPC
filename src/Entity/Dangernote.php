<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Dangernote
 *
 * @ORM\Table(name="dangernote", uniqueConstraints={@ORM\UniqueConstraint(name="id_dangerNote", columns={"id_dangerNote"})})
 * @ORM\Entity
 */
class Dangernote
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_dangerNote", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDangernote;

    /**
     * @var string
     *
     * @ORM\Column(name="name_dangerNote", type="string", length=50, nullable=false)
     */
    private $nameDangernote;

    /**
     * @var string
     *
     * @ORM\Column(name="sentenceDangerNote", type="string", length=500, nullable=false)
     */
    private $sentencedangernote;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Chimicalproduct", mappedBy="idDangernote")
     */
    private $idChimicalproduct;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idChimicalproduct = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdDangernote(): ?string
    {
        return $this->idDangernote;
    }

    public function getNameDangernote(): ?string
    {
        return $this->nameDangernote;
    }

    public function setNameDangernote(string $nameDangernote): self
    {
        $this->nameDangernote = $nameDangernote;

        return $this;
    }

    public function getSentencedangernote(): ?string
    {
        return $this->sentencedangernote;
    }

    public function setSentencedangernote(string $sentencedangernote): self
    {
        $this->sentencedangernote = $sentencedangernote;

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
            $idChimicalproduct->addIdDangernote($this);
        }

        return $this;
    }

    public function removeIdChimicalproduct(Chimicalproduct $idChimicalproduct): self
    {
        if ($this->idChimicalproduct->contains($idChimicalproduct)) {
            $this->idChimicalproduct->removeElement($idChimicalproduct);
            $idChimicalproduct->removeIdDangernote($this);
        }

        return $this;
    }

}
