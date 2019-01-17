<?php

namespace AppBundle\Service;

use AppBundle\Entity\OrderInterface;

/**
 * Interface ProcessingInterface
 * @package AppBundle\Service
 */
interface ProcessingInterface
{
    /**
     * @param OrderInterface $order
     * @param string $status
     */
    public function updateOrderStatus(OrderInterface $order, string $status);

    /**
     * @param string $customerEmail
     * @param array $cardData
     */
    public function updateCardToken(string $customerEmail, array $cardData);
}
