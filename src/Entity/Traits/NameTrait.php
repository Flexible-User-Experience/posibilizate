<?php

namespace App\Entity\Traits;

/**
 * Trait NameTrait.
 */
trait NameTrait
{
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return $this
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
