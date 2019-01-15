<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductOrder
 *
 * @ORM\Table(name="product_order")
 * @ORM\Entity
 */
class ProductOrder implements OrderInterface
{
    const GEO_COUNTRY = 'GBR';
    const CURRENCY = 'USD';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_email", type="string", length=255)
     */
    private $customerEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="geo_country", type="string", length=3)
     */
    private $geoCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=3)
     */
    private $currency;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_address", type="string", length=255)
     */
    private $ipAddress;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100)
     */
    private $description;

    /**
     * ProductOrder constructor.
     */
    public function __construct()
    {
        $this->setGeoCountry(static::GEO_COUNTRY);
        $this->setCurrency(static::CURRENCY);
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set customerEmail
     *
     * @param string $customerEmail
     *
     * @return ProductOrder
     */
    public function setCustomerEmail(string $customerEmail)
    {
        $this->customerEmail = $customerEmail;

        return $this;
    }

    /**
     * Get customerEmail
     *
     * @return string
     */
    public function getCustomerEmail(): ?string
    {
        return $this->customerEmail;
    }

    /**
     * Set geoCountry
     *
     * @param string $geoCountry
     *
     * @return ProductOrder
     */
    public function setGeoCountry(string $geoCountry)
    {
        $this->geoCountry = $geoCountry;

        return $this;
    }

    /**
     * Get geoCountry
     *
     * @return string
     */
    public function getGeoCountry(): ?string
    {
        return $this->geoCountry;
    }

    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return ProductOrder
     */
    public function setCurrency(string $currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     *
     * @return ProductOrder
     */
    public function setIpAddress(string $ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Get ipAddress
     *
     * @return string
     */
    public function getIpAddress(): ?string
    {
        return $this->ipAddress === '127.0.0.1' ? '159.224.217.26' : $this->ipAddress;
    }

    /**
     * @return int
     */
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return ProductOrder
     */
    public function setAmount(int $amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return ProductOrder
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }
}

