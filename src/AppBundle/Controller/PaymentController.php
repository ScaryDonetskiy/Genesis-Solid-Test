<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Card;
use AppBundle\Entity\CardToken;
use AppBundle\Entity\Product;
use AppBundle\Entity\ProductOrder;
use AppBundle\Service\PaymentInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('pay', SubmitType::class, ['label' => 'Pay'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ProductOrder $order */
            $order = $form->getData();
            $entityManager->persist($order);
            $order->setStatus($payment->initPayment($order));
            $entityManager->flush();

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
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param PaymentInterface $payment
     * @return Response
     */
    public function chargeAction(int $id, Request $request, EntityManagerInterface $entityManager, PaymentInterface $payment): Response
    {
        $order = $entityManager->getRepository(ProductOrder::class)->find($id);
        if (!$order) {
            throw $this->createNotFoundException();
        }

        $tokens = $entityManager->getRepository(CardToken::class)->findBy([
            'customerEmail' => $order->getCustomerEmail()
        ]);

        $card = new Card();
        $form = $this->createFormBuilder($card)
            ->add('number', TextType::class, ['label' => 'Card number'])
            ->add('holder', TextType::class, ['label' => 'Card holder'])
            ->add('expMonth', NumberType::class, ['label' => 'Expiration month'])
            ->add('expYear', NumberType::class, ['label' => 'Expiration year'])
            ->add('cvv', PasswordType::class, ['label' => 'CVV'])
            ->add('pay', SubmitType::class, ['label' => 'Pay'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $card = $form->getData();
            $payment->charge($order, $card);

            return $this->render('payment/charge_success.html.twig', [
                'order' => $order
            ]);
        }

        return $this->render('payment/charge.html.twig', [
            'order' => $order,
            'tokens' => $tokens,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/payment/recurring/{orderId}/{tokenId}/", name="recurring", requirements={"orderId"="\d+", "tokenId"="\d+"})
     * @param int $orderId
     * @param int $tokenId
     * @param EntityManagerInterface $entityManager
     * @param PaymentInterface $payment
     * @return Response
     */
    public function recurringAction(int $orderId, int $tokenId, EntityManagerInterface $entityManager, PaymentInterface $payment): Response
    {
        $order = $entityManager->getRepository(ProductOrder::class)->find($orderId);
        if (!$order) {
            throw $this->createNotFoundException();
        }
        $token = $entityManager->getRepository(CardToken::class)->find($tokenId);
        if (!$token) {
            throw $this->createNotFoundException();
        }
        $payment->recurring($order, $token);

        return $this->render('payment/recurring.html.twig', [
            'order' => $order,
            'token' => $token
        ]);
    }
}