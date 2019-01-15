<?php

namespace AppBundle\Controller;

use AppBundle\Entity\OrderInterface;
use AppBundle\Entity\ProductOrder;
use AppBundle\Service\PaymentInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OrderController
 * @package AppBundle\Controller
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/order/", name="order_list")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function indexAction(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(ProductOrder::class);

        return $this->render('order/index.html.twig', [
            'orders' => $repository->findBy([
                'status' => OrderInterface::STATUS_SUCCESS
            ])
        ]);
    }

    /**
     * @Route("/order/refund/{id}", name="refund", requirements={"id"="\d+"})
     * @param int $id
     * @param EntityManagerInterface $entityManager
     * @param PaymentInterface $payment
     * @return Response
     */
    public function refundAction(int $id, EntityManagerInterface $entityManager, PaymentInterface $payment): Response
    {
        $order = $entityManager->getRepository(ProductOrder::class)->find($id);
        if (!$order) {
            throw $this->createNotFoundException();
        }

        $payment->refund($order);
        $entityManager->remove($order);
        $entityManager->flush();

        return $this->render('order/refund.html.twig');
    }
}