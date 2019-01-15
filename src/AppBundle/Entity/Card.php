<?php

namespace AppBundle\Entity;

/**
 * Class Card
 * @package AppBundle\Entity
 */
class Card implements CardInterface
{
    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $holder;

    /**
     * @var string
     */
    private $expMonth;

    /**
     * @var string
     */
    private $expYear;

    /**
     * @var string
     */
    private $cvv;

    /**
     * @return string
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @param string $number
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getHolder(): ?string
    {
        return $this->holder;
    }

    /**
     * @param string $holder
     */
    public function setHolder(string $holder): void
    {
        $this->holder = $holder;
    }

    /**
     * @return string
     */
    public function getExpMonth(): ?string
    {
        return $this->expMonth;
    }

    /**
     * @param string $expMonth
     */
    public function setExpMonth(string $expMonth): void
    {
        $this->expMonth = $expMonth;
    }

    /**
     * @return string
     */
    public function getExpYear(): ?string
    {
        return $this->expYear;
    }

    /**
     * @param string $expYear
     */
    public function setExpYear(string $expYear): void
    {
        $this->expYear = $expYear;
    }

    /**
     * @return string
     */
    public function getCvv(): ?string
    {
        return $this->cvv;
    }

    /**
     * @param string $cvv
     */
    public function setCvv(string $cvv): void
    {
        $this->cvv = $cvv;
    }
}