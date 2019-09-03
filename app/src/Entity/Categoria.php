<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Categoria
 *
 * @ORM\Table(name="categoria")
 * @ORM\Entity
 */
class Categoria
{
    /**
     * @var int
     *
     * @ORM\Column(name="idcategoria", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idcategoria;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     */
    private $nome;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descricao", type="string", length=255, nullable=true)
     */
    private $descricao;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Aula", inversedBy="idcategoria")
     * @ORM\JoinTable(name="categoria_aula",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idcategoria", referencedColumnName="idcategoria")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idaula", referencedColumnName="idaula")
     *   }
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

    public function getIdcategoria(): ?int
    {
        return $this->idcategoria;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

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
