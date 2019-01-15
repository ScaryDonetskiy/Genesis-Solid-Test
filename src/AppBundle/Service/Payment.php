<?php

namespace AppBundle\Service;

use AppBundle\Entity\OrderInterface;
use AppBundle\Exception\PaymentException;
use Psr\Log\LoggerInterface;

/**
 * Class Payment
 * @package AppBundle\Service
 */
class Payment implements PaymentInterface
{
    /**
     * @var SolidGateInterface
     */
    protected $solidGate;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Payment constructor.
     * @param SolidGateInterface $solidGate
     * @param LoggerInterface $logger
     */
    public function __construct(SolidGateInterface $solidGate, LoggerInterface $logger)
    {
        $this->solidGate = $solidGate;
        $this->logger = $logger;
    }

    /**
     * @param OrderInterface $order
     * @return string
     * @throws PaymentException
     */
    public function initPayment(OrderInterface $order): string
    {
        $initPayment = $this->solidGate->initPayment([
            'amount' => $order->getAmount(),
            'currency' => $order->getCurrency(),
            'customer_email' => $order->getCustomerEmail(),
            'geo_country' => $order->getGeoCountry(),
            'ip_address' => $order->getIpAddress(),
            'order_id' => $order->getId(),
            'order_description' => $order->getDescription(),
            'platform' => SolidGateInterface::PLATFORM_WEB
        ]);

        if (array_key_exists('error', $initPayment)) {
            $this->logger->error(json_encode($initPayment['error']));
            throw new PaymentException($initPayment['error']['code']);
        }

        return $initPayment['order']['status'];
    }
}