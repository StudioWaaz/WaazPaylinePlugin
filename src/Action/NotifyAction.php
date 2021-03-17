<?php

/**
 * This file was created by the developers from Waaz.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://www.studiowaaz.com and write us
 * an email on developpement@studiowaaz.com.
 */

namespace Waaz\PaylinePlugin\Action;

use Waaz\PaylinePlugin\Bridge\PaylineBridgeInterface;
use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Exception\UnsupportedApiException;
use Payum\Core\GatewayAwareTrait;
use Sylius\Component\Core\Model\PaymentInterface;
use Payum\Core\Request\Notify;
use Sylius\Component\Payment\PaymentTransitions;
use Webmozart\Assert\Assert;
use SM\Factory\FactoryInterface;

/**
 * @author Ibes Mongabure <developpement@studiowaaz.com>
 */
final class NotifyAction implements ActionInterface, ApiAwareInterface
{
    use GatewayAwareTrait;

    /**
     * @var PaylineBridgeInterface
     */
    private $paylineBridge;

    /**
     * @var FactoryInterface
     */
    private $stateMachineFactory;

    /**
     * @param FactoryInterface $stateMachineFactory
     */
    public function __construct(FactoryInterface $stateMachineFactory)
    {
        $this->stateMachineFactory = $stateMachineFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function execute($request)
    {
        /** @var $request Notify */
        RequestNotSupportedException::assertSupports($this, $request);

        if ($this->paylineBridge->paymentVerification()) {

          $accessKey = $this->paylineBridge->getAccessKey();

          $payline = $this->paylineBridge->createPayline($accessKey);

          $payline->setFields([
            'merchant_id' => $this->paylineBridge->getMerchantId(),
            'access_key' => $this->paylineBridge->getAccessKey(),
            'environment' => $this->paylineBridge->getEnvironment()
          ]);
          $params['version'] = '3';
          $params['token'] = $this->paylineBridge->paymentVerification();

          $webPaymentDetails = $payline->getPaymentDetails($params);

          if($webPaymentDetails['result']['code'] == '00000'){

              /** @var PaymentInterface $payment */
              $payment = $request->getFirstModel();

              Assert::isInstanceOf($payment, PaymentInterface::class);

              $this->stateMachineFactory->get($payment, PaymentTransitions::GRAPH)->apply(PaymentTransitions::TRANSITION_COMPLETE);

          }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function setApi($paylineBridge)
    {
        if (!$paylineBridge instanceof PaylineBridgeInterface) {
            throw new UnsupportedApiException('Not supported.');
        }

        $this->paylineBridge = $paylineBridge;
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return
            $request instanceof Notify &&
            $request->getModel() instanceof \ArrayObject
        ;
    }
}
