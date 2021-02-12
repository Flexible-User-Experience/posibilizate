<?php

namespace App\Entity\Traits;

/**
 * Trait SlugTrait.
 */
trait SlugTrait
{
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @return $this
     */
    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
