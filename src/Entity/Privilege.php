<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Privilege
 *
 * @ORM\Table(name="privilege", uniqueConstraints={@ORM\UniqueConstraint(name="id_privilege", columns={"id_privilege"})})
 * @ORM\Entity
 */
class Privilege
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_privilege", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPrivilege;

    /**
     * @var string
     *
     * @ORM\Column(name="keyPrivilege", type="string", length=50, nullable=false)
     */
    private $keyprivilege;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Status", mappedBy="idPrivilege")
     */
    private $idStatus;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idStatus = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdPrivilege(): ?string
    {
        return $this->idPrivilege;
    }

    public function getKeyprivilege(): ?string
    {
        return $this->keyprivilege;
    }

    public function setKeyprivilege(string $keyprivilege): self
    {
        $this->keyprivilege = $keyprivilege;

        return $this;
    }

    /**
     * @return Collection|Status[]
     */
    public function getIdStatus(): Collection
    {
        return $this->idStatus;
    }

    public function addIdStatus(Status $idStatus): self
    {
        if (!$this->idStatus->contains($idStatus)) {
            $this->idStatus[] = $idStatus;
            $idStatus->addIdPrivilege($this);
        }

        return $this;
    }

    public function removeIdStatus(Status $idStatus): self
    {
        if ($this->idStatus->contains($idStatus)) {
            $this->idStatus->removeElement($idStatus);
            $idStatus->removeIdPrivilege($this);
        }

        return $this;
    }

}
