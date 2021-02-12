<?php

namespace App\Entity\Traits;

/**
 * Trait DescriptionTrait.
 */
trait DescriptionTrait
{
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
