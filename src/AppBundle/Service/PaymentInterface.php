<?php

namespace AppBundle\Service;

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
     * @return mixed
     */
    public function refund(OrderInterface $order): array;
}