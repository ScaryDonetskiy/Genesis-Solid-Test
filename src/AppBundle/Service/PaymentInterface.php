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
     */
    public function initPayment(OrderInterface $order);
}