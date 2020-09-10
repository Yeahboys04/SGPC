<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stock
 *
 * @ORM\Table(name="stock", uniqueConstraints={@ORM\UniqueConstraint(name="id_stock", columns={"id_stock"})}, indexes={@ORM\Index(name="FK_stock_site", columns={"id_site"})})
 * @ORM\Entity
 */
class Stock
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_stock", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idStock;

    /**
     * @var string
     *
     * @ORM\Column(name="name_stock", type="string", length=100, nullable=false)
     */
    private $nameStock;

    /**
     * @var \Site
     *
     * @ORM\ManyToOne(targetEntity="Site")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_site", referencedColumnName="id_site")
     * })
     */
    private $idSite;

    public function getIdStock(): ?string
    {
        return $this->idStock;
    }

    public function getNameStock(): ?string
    {
        return $this->nameStock;
    }

    public function setNameStock(string $nameStock): self
    {
        $this->nameStock = $nameStock;

        return $this;
    }

    public function getIdSite(): ?Site
    {
        return $this->idSite;
    }

    public function setIdSite(?Site $idSite): self
    {
        $this->idSite = $idSite;

        return $this;
    }


}
