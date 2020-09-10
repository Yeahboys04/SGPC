<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cupboard
 *
 * @ORM\Table(name="cupboard", uniqueConstraints={@ORM\UniqueConstraint(name="id_cupboard", columns={"id_cupboard"})}, indexes={@ORM\Index(name="FK_cupboard_stock", columns={"id_stock"})})
 * @ORM\Entity
 */
class Cupboard
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_cupboard", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCupboard;

    /**
     * @var string
     *
     * @ORM\Column(name="name_cupboard", type="string", length=100, nullable=false)
     */
    private $nameCupboard;

    /**
     * @var \Stock
     *
     * @ORM\ManyToOne(targetEntity="Stock")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_stock", referencedColumnName="id_stock")
     * })
     */
    private $idStock;

    public function getIdCupboard(): ?string
    {
        return $this->idCupboard;
    }

    public function getNameCupboard(): ?string
    {
        return $this->nameCupboard;
    }

    public function setNameCupboard(string $nameCupboard): self
    {
        $this->nameCupboard = $nameCupboard;

        return $this;
    }

    public function getIdStock(): ?Stock
    {
        return $this->idStock;
    }

    public function setIdStock(?Stock $idStock): self
    {
        $this->idStock = $idStock;

        return $this;
    }


}
