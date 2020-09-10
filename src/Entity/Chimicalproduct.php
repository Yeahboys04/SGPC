<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Chimicalproduct
 *
 * @ORM\Table(name="chimicalproduct", uniqueConstraints={@ORM\UniqueConstraint(name="id_chimicalProduct", columns={"id_chimicalProduct"})}, indexes={@ORM\Index(name="FK_chimicalProduct_document", columns={"id_document"})})
 * @ORM\Entity
 */
class Chimicalproduct
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_chimicalProduct", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idChimicalproduct;

    /**
     * @var string
     *
     * @ORM\Column(name="name_chimicalProduct", type="string", length=250, nullable=false)
     */
    private $nameChimicalproduct;

    /**
     * @var string|null
     *
     * @ORM\Column(name="formula", type="string", length=250, nullable=true)
     */
    private $formula;

    /**
     * @var string|null
     *
     * @ORM\Column(name="purity", type="string", length=50, nullable=true)
     */
    private $purity;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CASNumber", type="string", length=25, nullable=true)
     */
    private $casnumber;

    /**
     * @var bool
     *
     * @ORM\Column(name="isCMR", type="boolean", nullable=false)
     */
    private $iscmr;

    /**
     * @var \Document
     *
     * @ORM\ManyToOne(targetEntity="Document")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_document", referencedColumnName="id_document")
     * })
     */
    private $idDocument;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Cautionaryadvice", inversedBy="idChimicalproduct")
     * @ORM\JoinTable(name="productbycautionaryadvice",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_chimicalProduct", referencedColumnName="id_chimicalProduct")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_cautionaryAdvice", referencedColumnName="id_cautionaryAdvice")
     *   }
     * )
     */
    private $idCautionaryadvice;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Dangernote", inversedBy="idChimicalproduct")
     * @ORM\JoinTable(name="productbydangernote",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_chimicalProduct", referencedColumnName="id_chimicalProduct")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_dangerNote", referencedColumnName="id_dangerNote")
     *   }
     * )
     */
    private $idDangernote;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Dangersymbol", inversedBy="idChimicalproduct")
     * @ORM\JoinTable(name="productbydangersymbol",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_chimicalProduct", referencedColumnName="id_chimicalProduct")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_dangerSymbol", referencedColumnName="id_dangerSymbol")
     *   }
     * )
     */
    private $idDangersymbol;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Type", mappedBy="idChimicalproduct")
     */
    private $idType;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idCautionaryadvice = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idDangernote = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idDangersymbol = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idType = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdChimicalproduct(): ?string
    {
        return $this->idChimicalproduct;
    }

    public function getNameChimicalproduct(): ?string
    {
        return $this->nameChimicalproduct;
    }

    public function setNameChimicalproduct(string $nameChimicalproduct): self
    {
        $this->nameChimicalproduct = $nameChimicalproduct;

        return $this;
    }

    public function getFormula(): ?string
    {
        return $this->formula;
    }

    public function setFormula(?string $formula): self
    {
        $this->formula = $formula;

        return $this;
    }

    public function getPurity(): ?string
    {
        return $this->purity;
    }

    public function setPurity(?string $purity): self
    {
        $this->purity = $purity;

        return $this;
    }

    public function getCasnumber(): ?string
    {
        return $this->casnumber;
    }

    public function setCasnumber(?string $casnumber): self
    {
        $this->casnumber = $casnumber;

        return $this;
    }

    public function getIscmr(): ?bool
    {
        return $this->iscmr;
    }

    public function setIscmr(bool $iscmr): self
    {
        $this->iscmr = $iscmr;

        return $this;
    }

    public function getIdDocument(): ?Document
    {
        return $this->idDocument;
    }

    public function setIdDocument(?Document $idDocument): self
    {
        $this->idDocument = $idDocument;

        return $this;
    }

    /**
     * @return Collection|Cautionaryadvice[]
     */
    public function getIdCautionaryadvice(): Collection
    {
        return $this->idCautionaryadvice;
    }

    public function addIdCautionaryadvice(Cautionaryadvice $idCautionaryadvice): self
    {
        if (!$this->idCautionaryadvice->contains($idCautionaryadvice)) {
            $this->idCautionaryadvice[] = $idCautionaryadvice;
        }

        return $this;
    }

    public function removeIdCautionaryadvice(Cautionaryadvice $idCautionaryadvice): self
    {
        if ($this->idCautionaryadvice->contains($idCautionaryadvice)) {
            $this->idCautionaryadvice->removeElement($idCautionaryadvice);
        }

        return $this;
    }

    /**
     * @return Collection|Dangernote[]
     */
    public function getIdDangernote(): Collection
    {
        return $this->idDangernote;
    }

    public function addIdDangernote(Dangernote $idDangernote): self
    {
        if (!$this->idDangernote->contains($idDangernote)) {
            $this->idDangernote[] = $idDangernote;
        }

        return $this;
    }

    public function removeIdDangernote(Dangernote $idDangernote): self
    {
        if ($this->idDangernote->contains($idDangernote)) {
            $this->idDangernote->removeElement($idDangernote);
        }

        return $this;
    }

    /**
     * @return Collection|Dangersymbol[]
     */
    public function getIdDangersymbol(): Collection
    {
        return $this->idDangersymbol;
    }

    public function addIdDangersymbol(Dangersymbol $idDangersymbol): self
    {
        if (!$this->idDangersymbol->contains($idDangersymbol)) {
            $this->idDangersymbol[] = $idDangersymbol;
        }

        return $this;
    }

    public function removeIdDangersymbol(Dangersymbol $idDangersymbol): self
    {
        if ($this->idDangersymbol->contains($idDangersymbol)) {
            $this->idDangersymbol->removeElement($idDangersymbol);
        }

        return $this;
    }

    /**
     * @return Collection|Type[]
     */
    public function getIdType(): Collection
    {
        return $this->idType;
    }

    public function addIdType(Type $idType): self
    {
        if (!$this->idType->contains($idType)) {
            $this->idType[] = $idType;
            $idType->addIdChimicalproduct($this);
        }

        return $this;
    }

    public function removeIdType(Type $idType): self
    {
        if ($this->idType->contains($idType)) {
            $this->idType->removeElement($idType);
            $idType->removeIdChimicalproduct($this);
        }

        return $this;
    }

}
