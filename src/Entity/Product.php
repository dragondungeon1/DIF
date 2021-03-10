<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prodname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    /**
     * @ORM\OneToMany(targetEntity=Specification::class, mappedBy="product")
     */
    private $Specification;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $price;

    public function __construct()
    {
        $this->Specification = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProdname(): ?string
    {
        return $this->prodname;
    }

    public function setProdname(string $prodname): self
    {
        $this->prodname = $prodname;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return Collection|Specification[]
     */
    public function getSpecification(): Collection
    {
        return $this->Specification;
    }

    public function addSpecification(Specification $specification): self
    {
        if (!$this->Specification->contains($specification)) {
            $this->Specification[] = $specification;
            $specification->setProduct($this);
        }

        return $this;
    }

    public function removeSpecification(Specification $specification): self
    {
        if ($this->Specification->removeElement($specification)) {
            // set the owning side to null (unless already changed)
            if ($specification->getProduct() === $this) {
                $specification->setProduct(null);
            }
        }

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }
}
