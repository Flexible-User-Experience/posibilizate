<?php

namespace App\Entity\Traits;

/**
 * Trait ShortDescriptionTrait.
 */
trait ShortDescriptionTrait
{
    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    /**
     * @return $this
     */
    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }
}
