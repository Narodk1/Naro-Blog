<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use App\Entity\Images;
use App\Entity\Categorie;
use  App\Entity\Tag;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ORM\HasLifecycleCallbacks]

class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;

    #[ORM\Column(length: 255,unique: true)]
    #[Assert\NotBlank()]
    private ?string $titre ;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank()]
    private string $contenu;


    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;


    #[ORM\Column(type:'datetime_immutable')]
    private ?\DateTimeImmutable $updateAt;
    #[ORM\Column(type:'datetime_immutable')]
    private ?\DateTimeImmutable $createdAt;
    #[ORM\OneToOne(targetEntity: Images::class, inversedBy: 'Post', cascade: ['persist','remove'])]
    private ?Images $images =null;
    #[ORM\ManyToMany(targetEntity: Categorie::class, mappedBy: 'posts')]
    #[ORM\JoinTable(name: "post_categorie")]
    private Collection $categorie;
    #[ORM\ManyToMany(targetEntity: Tag::class, mappedBy: 'posts')]
    #[ORM\JoinTable(name: "tag_post")]
    private Collection $tags;



    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setUpdateAt(?\DateTimeImmutable $updateAt): void
    {
        $this->updateAt = $updateAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }



    /**
     * @var Collection<int, Commentaire>
     */
    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'post')]
    private Collection $commentaires;

    /**
     * @var Collection<int, Categorie>
     */


    public function setImages(Images $images): void
    {
        $this->images = $images;
    }

    public function setCommentaires(Collection $commentaires): void
    {
        $this->commentaires = $commentaires;
    }

    public function setCategories(Collection $categories): void
    {
        $this->categorie = $categories;
    }

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->images = new Images();
        $this->categorie = new ArrayCollection();
        $this->updateAt=new \DateTimeImmutable();
        $this->createdAt=new \DateTimeImmutable();
        $this->tags = new ArrayCollection();

    }
    #[ORM\PreUpdate]
    public function preUpdate (){
        $this->updateAt=new \DateTimeImmutable();

    }


    public function getId(): ?int
    {
        return $this->id;
    }




    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }
 

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
 

    public function addTag(Tag $tag): self {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addPost($this);
        }
    
        return $this;
    }
    
    public function removeTag(Tag $tag): self {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
            $tag->removePost($this);
        }
    
        return $this;
    }    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setPost($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getPost() === $this) {
                $commentaire->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategories(): Collection
    {
        return $this->categorie;
    }

    public function addCategory(Categorie $category): static
    {
        if (!$this->categorie->contains($category)) {
            $this->categorie->add($category);
            $category->addPost($this);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): static
    {
        if ($this->categorie->removeElement($category)) {
            $category->removePost($this);
        }

        return $this;
    }

    /**
     * @return \App\Entity\Images
     */
    public function getImages():?Images
    {
        return $this->images;
    }

    
}
