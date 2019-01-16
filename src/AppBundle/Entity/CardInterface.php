<?php

namespace AppBundle\Entity;

/**
 * Interface CardInterface
 * @package AppBundle\Entity
 */
interface CardInterface
{
    /**
     * @return string|null
     */
    public function getNumber(): ?string;

    /**
     * @return string|null
     */
    public function getHolder(): ?string;

    /**
     * @return string|null
     */
    public function getExpMonth(): ?string;

    /**
     * @return string|null
     */
    public function getExpYear(): ?string;

    /**
     * @return string|null
     */
    public function getCvv(): ?string;
}