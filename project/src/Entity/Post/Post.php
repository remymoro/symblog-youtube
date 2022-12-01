<?php

namespace App\Entity\Post;



use App\Entity\Post\Thumbnail;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;



#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(
    'slug',
    message: "Ce slug existe déjà, veuillez en choisir un autre"
)]
class Post
{


    const STATES = ['STATE_DRAFT', 'STATE_PUBLISHED'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private string $title;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank]
    private string $slug;


    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull]
    private \DateTimeImmutable $updatedAt;


    #[ORM\Column(type: 'string', length: 255)]
    private string $state = Post::STATES[0];


    #[ORM\Column(type: 'text')]
    private string $content;


    #[ORM\OneToOne(inversedBy: 'post', targetEntity: Thumbnail::class, cascade: ['persist', 'remove'])]
    private ?Thumbnail $thumbnail = null;




    function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }


    #[ORM\PrePersist]
    public function prePersit()
    {
        $this->slug = (new Slugify())->slugify($this->title);
    }


    #[ORM\PreUpdate]
    function preUpdate()
    {
        $this->updatedAt = new \DateTimeImmutable();
    }




    public function getId(): ?int
    {
        return $this->id;
    }


    public function getTitle(): string
    {
        return $this->title;
    }


    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }


    public function getSlug(): string
    {
        return $this->slug;
    }


    public function setSlug($slug): self
    {
        $this->slug = $slug;

        return $this;
    }


    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent($content): self
    {
        $this->content = $content;

        return $this;
    }


    public function getState()
    {
        return $this->state;
    }


    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }


    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }


    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }


    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }


    function __toString()
    {
        return $this->title;
    }


    public function getThumbnail(): ?Thumbnail
    {
        return $this->thumbnail;
    }


    public function setThumbnail(Thumbnail $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }
}
