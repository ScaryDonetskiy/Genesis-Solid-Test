<?php

namespace AppBundle\Service;

use AppBundle\Entity\CardInterface;
use AppBundle\Entity\OrderInterface;

/**
 * Interface PaymentInterface
 * @package AppBundle\Service
 */
interface PaymentInterface
{
    /**
     * @param OrderInterface $order
     * @return string
     */
    public function initPayment(OrderInterface $order): string;

    /**
     * @param OrderInterface $order
     * @param CardInterface $card
     * @return mixed
     */
    public function charge(OrderInterface $order, CardInterface $card);

    /**
     * @param OrderInterface $order
     * @return mixed
     */
    public function refund(OrderInterface $order): array;
}