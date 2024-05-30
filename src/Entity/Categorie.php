<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank()]  
      private ?string $nomCat = null;
    #[Assert\NotBlank()]
    #[ORM\Column(length: 255, unique: true)]
    private ?string $description = null;

    #[ORM\Column(type:'datetime_immutable')]    
    #[Assert\NotBlank()]  
    private ?\DateTimeImmutable $createdAt;
    /**
     * @var Collection<int, Post>
     */
    #[ORM\ManyToMany(targetEntity: Post::class, inversedBy: 'categorie')]
    #[ORM\JoinTable(name: "post_categorie")]

    private Collection $posts;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->posts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCat(): ?string
    {
        return $this->nomCat;
    }

    public function setNomCat(string $nomCat): static
    {
        $this->nomCat = $nomCat;

        return $this;
    }
    public function setDesc(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPost(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): static
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
        }

        return $this;
    }

    public function removePost(Post $post): static
    {
        $this->posts->removeElement($post);

        return $this;
    }
}
