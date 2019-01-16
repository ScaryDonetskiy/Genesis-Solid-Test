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
}