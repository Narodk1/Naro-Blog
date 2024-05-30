<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;
use App\Entity\Post;
use Doctrine\Common\Collections\ArrayCollection;



#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;
    
    #[ORM\ManyToMany(targetEntity: Post::class, inversedBy: 'tags')]
    #[ORM\JoinTable(name: "tag_post")]
    private Collection $posts;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull()]
    private \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->posts = new ArrayCollection();
    }

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
        }
    
        return $this;
    }
    
    public function removePost(Post $post): self {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
        }
    
        return $this;
    }



}
