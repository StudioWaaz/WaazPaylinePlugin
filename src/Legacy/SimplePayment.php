<?php

/**
 * This file was created by the developers from Waaz.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://www.studiowaaz.com and write us
 * an email on developpement@studiowaaz.com.
 */

namespace Waaz\PaylinePlugin\Legacy;

use Payum\Core\Reply\HttpResponse;

/**
 * @author Ibes Mongabure <developpement@studiowaaz.com>
 */
final class SimplePayment
{
    /**
     * @var Payline|object
     */
    private $payline;

    /**
     * @var string
     */
    private $environment;

    /**
     * @var string
     */
    private $paiementContractNumber;

    /**
     * @var string
     */
    private $merchantId;

    /**
     * @var string
     */
    private $accessKey;

    /**
     * @var string
     */
    private $amount;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $transactionReference;

    /**
     * @var string
     */
    private $automaticResponseUrl;

    /**
     * @var string
     */
    private $targetUrl;

    /**
     * @var string
     */
    private $cancelUrl;

    /**
     * @param Payline $payline
     * @param $merchantId
     * @param $environment
     * @param $amount
     * @param $targetUrl
     * @param $currency
     * @param $transactionReference
     * @param $automaticResponseUrl
     */
    public function __construct(
        Payline $payline,
        $merchantId,
        $accessKey,
        $environment,
        $paiementContractNumber,
        $amount,
        $targetUrl,
        $currency,
        $transactionReference,
        $automaticResponseUrl,
        $cancelUrl
    )
    {
        $this->automaticResponseUrl = $automaticResponseUrl;
        $this->transactionReference = $transactionReference;
        $this->payline = $payline;
        $this->environment = $environment;
        $this->paiementContractNumber = $paiementContractNumber;
        $this->merchantId = $merchantId;
        $this->accessKey = $accessKey;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->targetUrl = $targetUrl;
        $this->cancelUrl = $cancelUrl;
    }

    public function execute()
    {
        $this->payline->setFields([
          'merchant_id' => $this->merchantId,
          'access_key' => $this->accessKey,
          'environment' => $this->environment,
          'payment' => [
              'amount' => $this->amount,
              'currency' => CurrencyNumber::getByCode($this->currency),
              'contractNumber' => $this->paiementContractNumber,
          ],
          'order' => [
              'ref' => $this->transactionReference,
              'amount' => $this->amount,
              'currency' => CurrencyNumber::getByCode($this->currency),
          ],
          'cancel_url' => $this->cancelUrl,
          'return_url' => $this->targetUrl,
          'notification_url' => $this->automaticResponseUrl
        ]);

        // doit générer du html qui redirige vers la banque
        $response = $this->payline->executeRequest();

        throw new HttpResponse($response);
    }

    private function generateUniqueTransId() {
      $range = range(0, 899999);
      shuffle($range);
      return sprintf('%06d', $range[0]);
    }
}
