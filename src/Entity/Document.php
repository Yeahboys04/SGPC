<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 *
 * @ORM\Table(name="document", uniqueConstraints={@ORM\UniqueConstraint(name="id_document", columns={"id_document"})})
 * @ORM\Entity
 */
class Document
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_document", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDocument;

    /**
     * @var string
     *
     * @ORM\Column(name="name_document", type="string", length=250, nullable=false)
     */
    private $nameDocument;

    /**
     * @var string
     *
     * @ORM\Column(name="DATA", type="text", length=65535, nullable=false)
     */
    private $data;

    public function getIdDocument(): ?string
    {
        return $this->idDocument;
    }

    public function getNameDocument(): ?string
    {
        return $this->nameDocument;
    }

    public function setNameDocument(string $nameDocument): self
    {
        $this->nameDocument = $nameDocument;

        return $this;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(string $data): self
    {
        $this->data = $data;

        return $this;
    }


}
