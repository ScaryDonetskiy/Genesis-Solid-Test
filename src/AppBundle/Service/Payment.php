<?php

namespace AppBundle\Service;

use AppBundle\Entity\CardInterface;
use AppBundle\Entity\CardTokenInterface;
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
     * @var ProcessingInterface
     */
    protected $processing;

    /**
     * Payment constructor.
     * @param SolidGateInterface $solidGate
     * @param LoggerInterface $logger
     * @param ProcessingInterface $processing
     */
    public function __construct(SolidGateInterface $solidGate, LoggerInterface $logger, ProcessingInterface $processing)
    {
        $this->solidGate = $solidGate;
        $this->logger = $logger;
        $this->processing = $processing;
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

        $this->checkResponseForErrors($initPayment);

        return $initPayment['order']['status'];
    }

    /**
     * @param OrderInterface $order
     * @param CardInterface $card
     * @throws PaymentException
     */
    public function charge(OrderInterface $order, CardInterface $card)
    {
        $data = $this->solidGate->charge([
            'order_id' => $order->getId(),
            'amount' => $order->getAmount(),
            'currency' => $order->getCurrency(),
            'card_number' => $card->getNumber(),
            'card_holder' => $card->getHolder(),
            'card_exp_month' => $card->getExpMonth(),
            'card_exp_year' => $card->getExpYear(),
            'card_cvv' => $card->getCvv(),
            'order_description' => $order->getDescription(),
            'customer_email' => $order->getCustomerEmail(),
            'ip_address' => $order->getIpAddress(),
            'platform' => SolidGateInterface::PLATFORM_WEB,
            'geo_country' => $order->getGeoCountry()
        ]);

        $this->checkResponseForErrors($data);

        $transactionId = $data['transaction']['id'];
        $orderStatus = $this->status($order);
        if (isset($orderStatus['transactions'][$transactionId]['card'])) {
            $this->processing->updateCardToken($order->getCustomerEmail(),
                $orderStatus['transactions'][$transactionId]['card']);
        }
    }

    /**
     * @param OrderInterface $order
     * @return mixed
     * @throws PaymentException
     */
    public function refund(OrderInterface $order): array
    {
        $data = $this->solidGate->refund([
            'order_id' => $order->getId(),
            'amount' => $order->getAmount()
        ]);

        $this->checkResponseForErrors($data);

        $this->processing->updateOrderStatus($order, $data['order']['status']);

        return $data;
    }

    /**
     * @param OrderInterface $order
     * @return array
     * @throws PaymentException
     */
    public function status(OrderInterface $order): array
    {
        $data = $this->solidGate->status([
            'order_id' => $order->getId()
        ]);

        $this->checkResponseForErrors($data);

        $this->processing->updateOrderStatus($order, $data['order']['status']);

        return $data;
    }

    /**
     * @param OrderInterface $order
     * @param CardTokenInterface $cardToken
     * @return array
     * @throws PaymentException
     */
    public function recurring(OrderInterface $order, CardTokenInterface $cardToken): array
    {
        $data = $this->solidGate->recurring([
            'order_id' => $order->getId(),
            'amount' => $order->getAmount(),
            'currency' => $order->getCurrency(),
            'recurring_token' => $cardToken->getToken(),
            'order_description' => $order->getDescription(),
            'customer_email' => $order->getCustomerEmail(),
            'ip_address' => $order->getIpAddress(),
            'platform' => SolidGateInterface::PLATFORM_WEB
        ]);

        $this->checkResponseForErrors($data);

        $this->processing->updateOrderStatus($order, $data['order']['status']);

        return $data;
    }

    /**
     * @param array $response
     * @throws PaymentException
     */
    private function checkResponseForErrors(array $response)
    {
        if (isset($response['error'])) {
            $this->logger->error(json_encode($response['error']));
            throw new PaymentException($response['error']['code']);
        }
    }
}
