<?php

namespace App\Entity;

use App\Repository\TrickRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as CustomAssert;

#[ORM\Entity(repositoryClass: TrickRepository::class)]
#[UniqueEntity('name', message: "Une figure portant le même nom existe déjà")]
class Trick
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 30, unique: true)]
    #[Assert\NotBlank(message: 'Le nom ne doit pas être vide')]
    #[Assert\Length(max: 30, maxMessage: 'Le nom dépasse la limite autorisée de {{ limit }} caractères')]
    #[Groups(['trick:read'])]
    private string $name;

    #[Assert\Image(groups: ['create'])]
    #[Assert\NotBlank(message: "L'image de couverture ne doit pas être vide", groups: ['create'])]
    private ?UploadedFile $cover = null;

    #[ORM\Column(length: 255)]
    #[Groups(['trick:read'])]
    private string $coverWebPath = '';

    #[ORM\Column(type: 'text', length: 3000)]
    #[Assert\Length(max: 3000, maxMessage: 'La description dépasse la limite autorisée de {{ limit }} caractères')]
    #[Assert\NotBlank(message: 'La description ne doit pas être vide')]
    #[Groups(['trick:read'])]
    private string $description;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le slug ne doit pas être vide')]
    #[Assert\Length(max: 255, maxMessage: 'Le slug dépasse la limite autorisée de {{ limit }} caractères')]
    #[CustomAssert\Slug()]
    #[Groups(['trick:read'])]
    private string $slug;

    #[ORM\Column]
    #[Groups(['trick:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['trick:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'trick', targetEntity: Video::class, cascade: ['persist'], orphanRemoval: true)]
    #[Assert\Valid]
    private Collection $videos;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn()]
    #[Groups(['trick:read'])]
    private Group $category;

    #[ORM\OneToMany(mappedBy: 'trick', targetEntity: Image::class, cascade: ['persist'], orphanRemoval: true)]
    #[Assert\Valid]
    private Collection $images;

    #[ORM\OneToMany(mappedBy: 'trick', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    public function __construct()
    {
        $this->videos = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?Uuid
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

    public function getCover(): ?UploadedFile
    {
        return $this->cover;
    }

    public function setCover(UploadedFile $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Video>
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos->add($video);
            $video->setTrick($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getTrick() === $this) {
                $video->setTrick(null);
            }
        }

        return $this;
    }

    public function getCategory(): Group
    {
        return $this->category;
    }

    public function setCategory(Group $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCoverWebPath(): string
    {
        return $this->coverWebPath;
    }

    public function setCoverWebPath(string $coverWebPath): self
    {
        $this->coverWebPath = $coverWebPath;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setTrick($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getTrick() === $this) {
                $image->setTrick(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setTrick($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTrick() === $this) {
                $comment->setTrick(null);
            }
        }

        return $this;
    }
}
