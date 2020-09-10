<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Status
 *
 * @ORM\Table(name="status", uniqueConstraints={@ORM\UniqueConstraint(name="id_status", columns={"id_status"})})
 * @ORM\Entity
 */
class Status
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_status", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="name_status", type="string", length=50, nullable=false)
     */
    private $nameStatus;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Privilege", inversedBy="idStatus")
     * @ORM\JoinTable(name="acl",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_status", referencedColumnName="id_status")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_privilege", referencedColumnName="id_privilege")
     *   }
     * )
     */
    private $idPrivilege;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idPrivilege = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdStatus(): ?string
    {
        return $this->idStatus;
    }

    public function getNameStatus(): ?string
    {
        return $this->nameStatus;
    }

    public function setNameStatus(string $nameStatus): self
    {
        $this->nameStatus = $nameStatus;

        return $this;
    }

    /**
     * @return Collection|Privilege[]
     */
    public function getIdPrivilege(): Collection
    {
        return $this->idPrivilege;
    }

    public function addIdPrivilege(Privilege $idPrivilege): self
    {
        if (!$this->idPrivilege->contains($idPrivilege)) {
            $this->idPrivilege[] = $idPrivilege;
        }

        return $this;
    }

    public function removeIdPrivilege(Privilege $idPrivilege): self
    {
        if ($this->idPrivilege->contains($idPrivilege)) {
            $this->idPrivilege->removeElement($idPrivilege);
        }

        return $this;
    }

}
