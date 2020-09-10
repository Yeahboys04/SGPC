<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Dangersymbol
 *
 * @ORM\Table(name="dangersymbol", uniqueConstraints={@ORM\UniqueConstraint(name="id_dangerSymbol", columns={"id_dangerSymbol"})})
 * @ORM\Entity
 */
class Dangersymbol
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_dangerSymbol", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDangersymbol;

    /**
     * @var string
     *
     * @ORM\Column(name="name_dangerSymbol", type="string", length=50, nullable=false)
     */
    private $nameDangersymbol;

    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="blob", length=0, nullable=false)
     */
    private $icon;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Chimicalproduct", mappedBy="idDangersymbol")
     */
    private $idChimicalproduct;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idChimicalproduct = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdDangersymbol(): ?string
    {
        return $this->idDangersymbol;
    }

    public function getNameDangersymbol(): ?string
    {
        return $this->nameDangersymbol;
    }

    public function setNameDangersymbol(string $nameDangersymbol): self
    {
        $this->nameDangersymbol = $nameDangersymbol;

        return $this;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function setIcon($icon): self
    {
        $this->icon = $icon;

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
            $idChimicalproduct->addIdDangersymbol($this);
        }

        return $this;
    }

    public function removeIdChimicalproduct(Chimicalproduct $idChimicalproduct): self
    {
        if ($this->idChimicalproduct->contains($idChimicalproduct)) {
            $this->idChimicalproduct->removeElement($idChimicalproduct);
            $idChimicalproduct->removeIdDangersymbol($this);
        }

        return $this;
    }

}
