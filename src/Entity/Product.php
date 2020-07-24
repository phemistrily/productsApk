<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=13, unique=true)
     * @Assert\Length(
     *  min = 13,
     *  max = 13
     * )
     */
    private $bar_code_ean13;

    /**
     * @ORM\OneToMany(targetEntity=ProductStock::class, mappedBy="product", orphanRemoval=true)
     */
    private $product_stock;

    /**
     * @ORM\ManyToMany(targetEntity=ProductOwner::class, inversedBy="products")
     */
    private $product_owner;

    public function __construct()
    {
        $this->product_stock = new ArrayCollection();
        $this->product_owner = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBarCodeEan13(): ?string
    {
        return $this->bar_code_ean13;
    }

    public function setBarCodeEan13(string $bar_code_ean13): self
    {
        $this->bar_code_ean13 = $bar_code_ean13;

        return $this;
    }

    /**
     * @return Collection|ProductStock[]
     */
    public function getProductStock(): Collection
    {
        return $this->product_stock;
    }

    public function addProductStock(ProductStock $productStock): self
    {
        if (!$this->product_stock->contains($productStock)) {
            $this->product_stock[] = $productStock;
            $productStock->setProduct($this);
        }

        return $this;
    }

    public function removeProductStock(ProductStock $productStock): self
    {
        if ($this->product_stock->contains($productStock)) {
            $this->product_stock->removeElement($productStock);
            // set the owning side to null (unless already changed)
            if ($productStock->getProduct() === $this) {
                $productStock->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProductOwner[]
     */
    public function getProductOwner(): Collection
    {
        return $this->product_owner;
    }

    public function addProductOwner(ProductOwner $productOwner): self
    {
        if (!$this->product_owner->contains($productOwner)) {
            $this->product_owner[] = $productOwner;
        }

        return $this;
    }

    public function removeProductOwner(ProductOwner $productOwner): self
    {
        if ($this->product_owner->contains($productOwner)) {
            $this->product_owner->removeElement($productOwner);
        }

        return $this;
    }
}
