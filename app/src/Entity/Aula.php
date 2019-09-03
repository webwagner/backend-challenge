<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Aula
 *
 * @ORM\Table(name="aula")
 * @ORM\Entity
 */
class Aula
{
    /**
     * @var int
     *
     * @ORM\Column(name="idaula", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idaula;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     */
    private $titulo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descricao", type="string", length=255, nullable=true)
     */
    private $descricao;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     * @Assert\Url
     */
    private $link;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Categoria", mappedBy="idaula")
     */
    private $idcategoria;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Curso", mappedBy="idaula")
     */
    private $idcurso;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idcategoria = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idcurso = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdaula(): ?int
    {
        return $this->idaula;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(?string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return Collection|Categoria[]
     */
    public function getIdcategoria(): Collection
    {
        return $this->idcategoria;
    }

    public function addIdcategorium(Categoria $idcategorium): self
    {
        if (!$this->idcategoria->contains($idcategorium)) {
            $this->idcategoria[] = $idcategorium;
            $idcategorium->addIdaula($this);
        }

        return $this;
    }

    public function removeIdcategorium(Categoria $idcategorium): self
    {
        if ($this->idcategoria->contains($idcategorium)) {
            $this->idcategoria->removeElement($idcategorium);
            $idcategorium->removeIdaula($this);
        }

        return $this;
    }

    /**
     * @return Collection|Curso[]
     */
    public function getIdcurso(): Collection
    {
        return $this->idcurso;
    }

    public function addIdcurso(Curso $idcurso): self
    {
        if (!$this->idcurso->contains($idcurso)) {
            $this->idcurso[] = $idcurso;
            $idcurso->addIdaula($this);
        }

        return $this;
    }

    public function removeIdcurso(Curso $idcurso): self
    {
        if ($this->idcurso->contains($idcurso)) {
            $this->idcurso->removeElement($idcurso);
            $idcurso->removeIdaula($this);
        }

        return $this;
    }

}
