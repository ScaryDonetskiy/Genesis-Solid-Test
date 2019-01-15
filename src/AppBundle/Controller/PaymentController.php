<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Entity\ProductOrder;
use AppBundle\Service\PaymentInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PaymentController
 * @package AppBundle\Controller
 */
class PaymentController extends AbstractController
{
    /**
     * @Route("/payment/buy/{id}/", name="buy", requirements={"id"="\d+"})
     * @param int $id
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param PaymentInterface $payment
     * @return Response
     */
    public function buyAction(int $id, Request $request, EntityManagerInterface $entityManager, PaymentInterface $payment): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);
        if (!$product) {
            throw $this->createNotFoundException();
        }

        $order = new ProductOrder();
        $order->setIpAddress($request->getClientIp());
        $order->setAmount($product->getPrice());
        $order->setDescription('Order: ' . $product->getTitle());
        $form = $this->createFormBuilder($order)
            ->add('customerEmail', EmailType::class)
            ->add('save', SubmitType::class, ['label' => 'Pay'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order = $form->getData();
            $entityManager->persist($order);
            $entityManager->flush();
            $payment->initPayment($order);

            return $this->redirectToRoute('charge', ['id' => $order->getId()]);
        }

        return $this->render('payment/buy.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/payment/charge/{id}/", name="charge", requirements={"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function chargeAction(int $id): Response
    {
        return new Response('not implemented');
    }
}