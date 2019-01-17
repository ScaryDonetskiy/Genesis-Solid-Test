<?php

namespace AppBundle\Entity;

/**
 * Interface CardTokenInterface
 * @package AppBundle\Entity
 */
interface CardTokenInterface
{
    /**
     * @return string|null
     */
    public function getToken(): ?string;
}
