<?php

namespace App\Entity;

use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\ImageAttributesTrait;
use App\Entity\Traits\IsAvailableTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\ShortDescriptionTrait;
use App\Entity\Traits\SlugTrait;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BlogPostRepository")
 * @UniqueEntity("name")
 * @Vich\Uploadable
 */
class BlogPost extends AbstractEntity
{
    use NameTrait;
    use SlugTrait;
    use ImageAttributesTrait;
    use ShortDescriptionTrait;
    use DescriptionTrait;
    use IsAvailableTrait;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"name"})
     *
     * @var string
     */
    private $slug;

    /**
     * @ORM\Column(type="date")
     *
     * @var DateTime
     */
    private $published;

    /**
     * @Vich\UploadableField(mapping="blog", fileNameProperty="imageName", size="imageSize")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var int
     */
    private $imageSize;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $shortDescription;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default"=1})
     *
     * @var bool
     */
    private $isAvailable;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\BlogCategory", inversedBy="posts")
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     *
     * @var ArrayCollection
     */
    private $tags;

    /**
     * Methods.
     */

    /**
     * EventCategory constructor.
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getPublished(): ?DateTime
    {
        return $this->published;
    }

    /**
     * @return $this|null
     */
    public function setPublished(?DateTime $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * @return $this
     */
    public function addTag(BlogCategory $category): self
    {
        if (!$this->tags->contains($category)) {
            $this->tags[] = $category;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function removeTag(BlogCategory $category): self
    {
        if ($this->tags->contains($category)) {
            $this->tags->removeElement($category);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->id ? $this->getName() : '---';
    }
}
