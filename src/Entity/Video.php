<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV6;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
final class Video
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?UuidV6 $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(allowNull: false)]
    #[Assert\Url(message: "L'url n'est pas valide ou ne commence pas par : https://", protocols: ['https'])]
    private string $url;

    #[ORM\ManyToOne(inversedBy: 'videos')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Trick $trick;

    public function getId(): ?UuidV6
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getTrick(): Trick
    {
        return $this->trick;
    }

    public function setTrick(Trick $trick): self
    {
        $this->trick = $trick;

        return $this;
    }
}
