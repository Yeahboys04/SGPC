<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Site
 *
 * @ORM\Table(name="site", uniqueConstraints={@ORM\UniqueConstraint(name="id_site", columns={"id_site"})})
 * @ORM\Entity
 */
class Site
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_site", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSite;

    /**
     * @var string
     *
     * @ORM\Column(name="name_site", type="string", length=50, nullable=false)
     */
    private $nameSite;

    /**
     * @var string
     *
     * @ORM\Column(name="fullnameSupervisor", type="string", length=250, nullable=false)
     */
    private $fullnamesupervisor;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneNumber", type="string", length=10, nullable=false, options={"fixed"=true})
     */
    private $phonenumber;

    public function getIdSite(): ?string
    {
        return $this->idSite;
    }

    public function getNameSite(): ?string
    {
        return $this->nameSite;
    }

    public function setNameSite(string $nameSite): self
    {
        $this->nameSite = $nameSite;

        return $this;
    }

    public function getFullnamesupervisor(): ?string
    {
        return $this->fullnamesupervisor;
    }

    public function setFullnamesupervisor(string $fullnamesupervisor): self
    {
        $this->fullnamesupervisor = $fullnamesupervisor;

        return $this;
    }

    public function getPhonenumber(): ?string
    {
        return $this->phonenumber;
    }

    public function setPhonenumber(string $phonenumber): self
    {
        $this->phonenumber = $phonenumber;

        return $this;
    }


}
