<?php

namespace AppBundle\Entity;

/**
 * Interface CardTokenInterface
 * @package AppBundle\Entity
 */
interface CardTokenInterface
{
    /**
     * @return string
     */
    public function getToken(): string;
}
