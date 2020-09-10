<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Storagecard
 *
 * @ORM\Table(name="storagecard", uniqueConstraints={@ORM\UniqueConstraint(name="id_storageCard", columns={"id_storageCard"})}, indexes={@ORM\Index(name="FK_storageCard_chimicalProduct", columns={"id_chimicalProduct"}), @ORM\Index(name="FK_storageCard_property", columns={"id_property"}), @ORM\Index(name="FK_storageCard_shelvingUnit", columns={"id_shelvingUnit"})})
 * @ORM\Entity
 */
class Storagecard
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_storageCard", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idStoragecard;

    /**
     * @var int
     *
     * @ORM\Column(name="stockQuantity", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $stockquantity;

    /**
     * @var int
     *
     * @ORM\Column(name="capacity", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $capacity;

    /**
     * @var string|null
     *
     * @ORM\Column(name="serialNumber", type="string", length=50, nullable=true)
     */
    private $serialnumber;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="openDate", type="date", nullable=true)
     */
    private $opendate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="expirationDate", type="date", nullable=true)
     */
    private $expirationdate;

    /**
     * @var bool
     *
     * @ORM\Column(name="isArchived", type="boolean", nullable=false)
     */
    private $isarchived;

    /**
     * @var \Chimicalproduct
     *
     * @ORM\ManyToOne(targetEntity="Chimicalproduct")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_chimicalProduct", referencedColumnName="id_chimicalProduct")
     * })
     */
    private $idChimicalproduct;

    /**
     * @var \Property
     *
     * @ORM\ManyToOne(targetEntity="Property")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_property", referencedColumnName="id_property")
     * })
     */
    private $idProperty;

    /**
     * @var \Shelvingunit
     *
     * @ORM\ManyToOne(targetEntity="Shelvingunit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_shelvingUnit", referencedColumnName="id_shelvingUnit")
     * })
     */
    private $idShelvingunit;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Supplier", mappedBy="idStoragecard")
     */
    private $idSupplier;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="idStoragecard")
     */
    private $idUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idSupplier = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idUser = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdStoragecard(): ?string
    {
        return $this->idStoragecard;
    }

    public function getStockquantity(): ?string
    {
        return $this->stockquantity;
    }

    public function setStockquantity(string $stockquantity): self
    {
        $this->stockquantity = $stockquantity;

        return $this;
    }

    public function getCapacity(): ?string
    {
        return $this->capacity;
    }

    public function setCapacity(string $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getSerialnumber(): ?string
    {
        return $this->serialnumber;
    }

    public function setSerialnumber(?string $serialnumber): self
    {
        $this->serialnumber = $serialnumber;

        return $this;
    }

    public function getOpendate(): ?\DateTimeInterface
    {
        return $this->opendate;
    }

    public function setOpendate(?\DateTimeInterface $opendate): self
    {
        $this->opendate = $opendate;

        return $this;
    }

    public function getExpirationdate(): ?\DateTimeInterface
    {
        return $this->expirationdate;
    }

    public function setExpirationdate(?\DateTimeInterface $expirationdate): self
    {
        $this->expirationdate = $expirationdate;

        return $this;
    }

    public function getIsarchived(): ?bool
    {
        return $this->isarchived;
    }

    public function setIsarchived(bool $isarchived): self
    {
        $this->isarchived = $isarchived;

        return $this;
    }

    public function getIdChimicalproduct(): ?Chimicalproduct
    {
        return $this->idChimicalproduct;
    }

    public function setIdChimicalproduct(?Chimicalproduct $idChimicalproduct): self
    {
        $this->idChimicalproduct = $idChimicalproduct;

        return $this;
    }

    public function getIdProperty(): ?Property
    {
        return $this->idProperty;
    }

    public function setIdProperty(?Property $idProperty): self
    {
        $this->idProperty = $idProperty;

        return $this;
    }

    public function getIdShelvingunit(): ?Shelvingunit
    {
        return $this->idShelvingunit;
    }

    public function setIdShelvingunit(?Shelvingunit $idShelvingunit): self
    {
        $this->idShelvingunit = $idShelvingunit;

        return $this;
    }

    /**
     * @return Collection|Supplier[]
     */
    public function getIdSupplier(): Collection
    {
        return $this->idSupplier;
    }

    public function addIdSupplier(Supplier $idSupplier): self
    {
        if (!$this->idSupplier->contains($idSupplier)) {
            $this->idSupplier[] = $idSupplier;
            $idSupplier->addIdStoragecard($this);
        }

        return $this;
    }

    public function removeIdSupplier(Supplier $idSupplier): self
    {
        if ($this->idSupplier->contains($idSupplier)) {
            $this->idSupplier->removeElement($idSupplier);
            $idSupplier->removeIdStoragecard($this);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getIdUser(): Collection
    {
        return $this->idUser;
    }

    public function addIdUser(User $idUser): self
    {
        if (!$this->idUser->contains($idUser)) {
            $this->idUser[] = $idUser;
            $idUser->addIdStoragecard($this);
        }

        return $this;
    }

    public function removeIdUser(User $idUser): self
    {
        if ($this->idUser->contains($idUser)) {
            $this->idUser->removeElement($idUser);
            $idUser->removeIdStoragecard($this);
        }

        return $this;
    }

}
