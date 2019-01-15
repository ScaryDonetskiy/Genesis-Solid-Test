<?php

namespace AppBundle\Entity;

/**
 * Interface OrderInterface
 * @package AppBundle\Entity
 */
interface OrderInterface
{
    /**
     * @return int
     */
    public function getId(): ?int;

    /**
     * @return string
     */
    public function getCustomerEmail(): ?string;

    /**
     * @return string
     */
    public function getGeoCountry(): ?string;

    /**
     * @return string
     */
    public function getCurrency(): ?string;

    /**
     * @return string
     */
    public function getIpAddress(): ?string;

    /**
     * @return int
     */
    public function getAmount(): ?int;

    /**
     * @return string
     */
    public function getDescription(): ?string;

    /**
     * @return string
     */
    public function getStatus(): ?string;
}