<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Property
 *
 * @ORM\Table(name="property", uniqueConstraints={@ORM\UniqueConstraint(name="id_property", columns={"id_property"})})
 * @ORM\Entity
 */
class Property
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_property", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProperty;

    /**
     * @var string
     *
     * @ORM\Column(name="name_property", type="string", length=250, nullable=false)
     */
    private $nameProperty;

    public function getIdProperty(): ?string
    {
        return $this->idProperty;
    }

    public function getNameProperty(): ?string
    {
        return $this->nameProperty;
    }

    public function setNameProperty(string $nameProperty): self
    {
        $this->nameProperty = $nameProperty;

        return $this;
    }


}
