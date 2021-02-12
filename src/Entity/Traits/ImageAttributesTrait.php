<?php

namespace App\Entity\Traits;

use DateTimeImmutable;
use Exception;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Trait ImageAttributesTrait.
 */
trait ImageAttributesTrait
{
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @return $this
     *
     * @throws Exception
     */
    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;
        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updated = new DateTimeImmutable();
        }

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @return $this
     */
    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    /**
     * @return $this
     */
    public function setImageSize(?int $imageSize): self
    {
        $this->imageSize = $imageSize;

        return $this;
    }
}
