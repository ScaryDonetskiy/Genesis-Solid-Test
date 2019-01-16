<?php

namespace AppBundle\Service;

use AppBundle\Entity\OrderInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class Processing
 * @package AppBundle\Service
 */
class Processing implements ProcessingInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Processing constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param OrderInterface $order
     * @param string $status
     */
    public function updateOrderStatus(OrderInterface $order, string $status)
    {
        $order->setStatus($status);
        $this->entityManager->flush();
    }
}