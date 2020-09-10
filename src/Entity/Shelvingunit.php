<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Shelvingunit
 *
 * @ORM\Table(name="shelvingunit", uniqueConstraints={@ORM\UniqueConstraint(name="id_shelvingUnit", columns={"id_shelvingUnit"})}, indexes={@ORM\Index(name="FK_shelvingUnit_cupboard", columns={"id_cupboard"})})
 * @ORM\Entity
 */
class Shelvingunit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_shelvingUnit", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idShelvingunit;

    /**
     * @var string
     *
     * @ORM\Column(name="name_shelvingUnit", type="string", length=100, nullable=false)
     */
    private $nameShelvingunit;

    /**
     * @var \Cupboard
     *
     * @ORM\ManyToOne(targetEntity="Cupboard")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cupboard", referencedColumnName="id_cupboard")
     * })
     */
    private $idCupboard;

    public function getIdShelvingunit(): ?string
    {
        return $this->idShelvingunit;
    }

    public function getNameShelvingunit(): ?string
    {
        return $this->nameShelvingunit;
    }

    public function setNameShelvingunit(string $nameShelvingunit): self
    {
        $this->nameShelvingunit = $nameShelvingunit;

        return $this;
    }

    public function getIdCupboard(): ?Cupboard
    {
        return $this->idCupboard;
    }

    public function setIdCupboard(?Cupboard $idCupboard): self
    {
        $this->idCupboard = $idCupboard;

        return $this;
    }


}
