<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Curso
 *
 * @ORM\Table(name="curso")
 * @ORM\Entity
 */
class Curso
{
    /**
     * @var int
     *
     * @ORM\Column(name="idcurso", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idcurso;

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
     * @ORM\Column(name="tipo", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     */
    private $tipo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Aula", inversedBy="idcurso")
     * @ORM\JoinTable(name="curso_aula",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idcurso", referencedColumnName="idcurso")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idaula", referencedColumnName="idaula")
     *   }
     * )
     * @Assert\Count(
     *      min = "1",
     *      minMessage = "You have to select at least 1 aula"
     * )
     */
    
    private $idaula;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idaula = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdcurso(): ?int
    {
        return $this->idcurso;
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

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * @return Collection|Aula[]
     */
    public function getIdaula(): Collection
    {
        return $this->idaula;
    }

    public function addIdaula(Aula $idaula): self
    {
        if (!$this->idaula->contains($idaula)) {
            $this->idaula[] = $idaula;
        }

        return $this;
    }

    public function removeIdaula(Aula $idaula): self
    {
        if ($this->idaula->contains($idaula)) {
            $this->idaula->removeElement($idaula);
        }

        return $this;
    }

}
