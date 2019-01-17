<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CardToken
 *
 * @ORM\Table(name="card_token")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CardTokenRepository")
 */
class CardToken implements CardTokenInterface
{
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
     * @ORM\Column(name="card_number", type="string", length=255)
     */
    private $cardNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set customerEmail
     *
     * @param string $customerEmail
     *
     * @return CardToken
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
    public function getCustomerEmail(): string
    {
        return (string)$this->customerEmail;
    }

    /**
     * Set cardNumber
     *
     * @param string $cardNumber
     *
     * @return CardToken
     */
    public function setCardNumber(string $cardNumber)
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * Get cardNumber
     *
     * @return string
     */
    public function getCardNumber(): string
    {
        return (string)$this->cardNumber;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return CardToken
     */
    public function setToken(string $token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken(): string
    {
        return (string)$this->token;
    }
}
