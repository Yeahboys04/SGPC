<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="id_user", columns={"id_user"})}, indexes={@ORM\Index(name="FK_user_status", columns={"id_status"})})
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=250, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="fullName", type="string", length=250, nullable=false)
     */
    private $fullname;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=250, nullable=false)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=250, nullable=false)
     */
    private $password;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="endRightDate", type="date", nullable=true)
     */
    private $endrightdate;

    /**
     * @var \Status
     *
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_status", referencedColumnName="id_status")
     * })
     */
    private $idStatus;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Storagecard", inversedBy="idUser")
     * @ORM\JoinTable(name="tracability",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
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

    public function getIdUser(): ?string
    {
        return $this->idUser;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getRoles()
    {
        return array($this->getIdStatus()->getNameStatus());
    }

    public function eraseCredentials()
    {
    }

    public function getEndrightdate(): ?\DateTimeInterface
    {
        return $this->endrightdate;
    }

    public function setEndrightdate(?\DateTimeInterface $endrightdate): self
    {
        $this->endrightdate = $endrightdate;

        return $this;
    }

    public function getIdStatus(): ?Status
    {
        return $this->idStatus;
    }

    public function setIdStatus(?Status $idStatus): self
    {
        $this->idStatus = $idStatus;

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

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->idUser,
            $this->username,
            $this->password,
            $this->fullname,
            $this->mail,
            $this->endrightdate
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->idUser,
            $this->username,
            $this->password,
            $this->fullname,
            $this->mail,
            $this->endrightdate
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }
}
