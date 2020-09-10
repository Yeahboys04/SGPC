<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Supplier
 *
 * @ORM\Table(name="supplier", uniqueConstraints={@ORM\UniqueConstraint(name="id_supplier", columns={"id_supplier"})})
 * @ORM\Entity
 */
class Supplier
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_supplier", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSupplier;

    /**
     * @var string
     *
     * @ORM\Column(name="name_supplier", type="string", length=250, nullable=false)
     */
    private $nameSupplier;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Storagecard", inversedBy="idSupplier")
     * @ORM\JoinTable(name="productbysupplier",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_supplier", referencedColumnName="id_supplier")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_storageCard", referencedColumnName="id_storageCard")
     *   }
     * )
     */
    private $idStoragecard;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idStoragecard = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdSupplier(): ?string
    {
        return $this->idSupplier;
    }

    public function getNameSupplier(): ?string
    {
        return $this->nameSupplier;
    }

    public function setNameSupplier(string $nameSupplier): self
    {
        $this->nameSupplier = $nameSupplier;

        return $this;
    }

    /**
     * @return Collection|Storagecard[]
     */
    public function getIdStoragecard(): Collection
    {
        return $this->idStoragecard;
    }

    public function addIdStoragecard(Storagecard $idStoragecard): self
    {
        if (!$this->idStoragecard->contains($idStoragecard)) {
            $this->idStoragecard[] = $idStoragecard;
        }

        return $this;
    }

    public function removeIdStoragecard(Storagecard $idStoragecard): self
    {
        if ($this->idStoragecard->contains($idStoragecard)) {
            $this->idStoragecard->removeElement($idStoragecard);
        }

        return $this;
    }

}
