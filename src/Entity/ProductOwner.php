<?php

namespace App\Entity;

use App\Repository\ProductOwnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductOwnerRepository::class)
 */
class ProductOwner
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
     * @ORM\ManyToMany(targetEntity=Product::class, mappedBy="product_owner")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity=ProductStock::class, mappedBy="productOwner", orphanRemoval=true)
     */
    private $productStocks;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->productStocks = new ArrayCollection();
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

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addProductOwner($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            $product->removeProductOwner($this);
        }

        return $this;
    }

    /**
     * @return Collection|ProductStock[]
     */
    public function getProductStocks(): Collection
    {
        return $this->productStocks;
    }

    public function addProductStock(ProductStock $productStock): self
    {
        if (!$this->productStocks->contains($productStock)) {
            $this->productStocks[] = $productStock;
            $productStock->setProductOwner($this);
        }

        return $this;
    }

    public function removeProductStock(ProductStock $productStock): self
    {
        if ($this->productStocks->contains($productStock)) {
            $this->productStocks->removeElement($productStock);
            // set the owning side to null (unless already changed)
            if ($productStock->getProductOwner() === $this) {
                $productStock->setProductOwner(null);
            }
        }

        return $this;
    }
}
