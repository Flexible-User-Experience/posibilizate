<?php

namespace App\Entity\Traits;

/**
 * Trait IsAvailableTrait.
 */
trait IsAvailableTrait
{
    public function getIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function isAvailable(): ?bool
    {
        return $this->getIsAvailable();
    }

    /**
     * @return $this
     */
    public function setIsAvailable(?bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }
}
