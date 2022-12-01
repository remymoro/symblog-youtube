<?php

namespace App\Entity\Post;

use App\Repository\Post\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;


    #[ORM\Column('string', length: 255)]
    private string $name;


    #[ORM\Column('string', length: 255)]
    private ?string $slug = '';


    private ?string $description = null;

  




    public function getId(): ?int
    {
        return $this->id;
    }
}
