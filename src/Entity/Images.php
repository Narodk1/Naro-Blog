<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]

class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Vich\UploadableField(mapping:'posts_image',fileNameProperty:'imageName',size:'imageSize')]
    private ?File $imageFile=null;
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $imageName =null;
    /**
     * @ORM\Column(nullable="true")
     */
    #[ORM\Column(type: 'integer')]
    private ?int $imageSize = null;
    #[ORM\Column(type: 'datetime_immutable')]

    private ?\DateTimeImmutable $updatedAt ;
    #[ORM\OneToOne(targetEntity: Post::class, mappedBy: 'images', cascade: ['persist','remove'])]
    private ?Post $Post = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }


    public function getPost(): ?Post
    {
        return $this->Post;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function setPost(?Post $Post): void
    {
        $this->Post = $Post;
    }
    public function __construct()
    {
        $this->updatedAt=new \DateTimeImmutable();
    }
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }


}