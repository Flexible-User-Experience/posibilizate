<?php

namespace App\Entity;

use App\Entity\Traits\IsAvailableTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\SlugTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BlogCategoryRepository")
 * @UniqueEntity("name")
 */
class BlogCategory extends AbstractEntity
{
    use NameTrait, SlugTrait, IsAvailableTrait;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"name"})
     */
    private string $slug;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default"=1})
     */
    private ?bool $isAvailable;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\BlogPost", mappedBy="tags")
     *
     * @var ArrayCollection
     */
    private $posts;

    /**
     * Methods.
     */

    /**
     * EventCategory constructor.
     */
    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    /**
     * @return Collection
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    /**
     * @param BlogPost $post
     *
     * @return $this
     */
    public function addPost(BlogPost $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
        }

        return $this;
    }

    /**
     * @param BlogPost $post
     *
     * @return $this
     */
    public function removePost(BlogPost $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->id ? $this->getName() : '---';
    }
}
