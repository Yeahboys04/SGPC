<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Type
 *
 * @ORM\Table(name="type", uniqueConstraints={@ORM\UniqueConstraint(name="id_type", columns={"id_type"})})
 * @ORM\Entity
 */
class Type
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_type", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idType;

    /**
     * @var string
     *
     * @ORM\Column(name="name_type", type="string", length=50, nullable=false)
     */
    private $nameType;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Chimicalproduct", inversedBy="idType")
     * @ORM\JoinTable(name="productbytype",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_type", referencedColumnName="id_type")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_chimicalProduct", referencedColumnName="id_chimicalProduct")
     *   }
     * )
     */
    private $idChimicalproduct;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idChimicalproduct = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdType(): ?string
    {
        return $this->idType;
    }

    public function getNameType(): ?string
    {
        return $this->nameType;
    }

    public function setNameType(string $nameType): self
    {
        $this->nameType = $nameType;

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
        }

        return $this;
    }

    public function removeIdChimicalproduct(Chimicalproduct $idChimicalproduct): self
    {
        if ($this->idChimicalproduct->contains($idChimicalproduct)) {
            $this->idChimicalproduct->removeElement($idChimicalproduct);
        }

        return $this;
    }

}
