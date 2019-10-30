<?php

/**
 * This file was created by the developers from Waaz.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://www.studiowaaz.com and write us
 * an email on developpement@studiowaaz.com.
 */

namespace Waaz\PaylinePlugin\Bridge;

use Waaz\PaylinePlugin\Legacy\Payline;
use Symfony\Component\HttpFoundation\RequestStack;


/**
 * @author Ibes Mongabure <developpement@studiowaaz.com>
 */
final class PaylineBridge implements PaylineBridgeInterface
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var string
     */
    private $accessKey;

    /**
     * @var string
     */
    private $merchantId;

    /**
     * @var string
     */
    private $environment;

    /**
     * @var string
     */
    private $paiementContractNumber;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * {@inheritDoc}
     */
    public function createPayline($accessKey)
    {
        return new Payline($accessKey);
    }

    /**
     * {@inheritDoc}
     */
    public function paymentVerification()
    {
        if ($this->isPostMethod()) {

            $postdata = $this->getPostData();

            return $postdata['token'];
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function isPostMethod()
    {

        $currentRequest = $this->requestStack->getCurrentRequest();

        return $currentRequest->isMethod('POST');
    }

    /**
     * @return array
     */
     public function getPostData()
     {
       $currentRequest = $this->requestStack->getCurrentRequest();

       return $currentRequest->query->all();
     }

    /**
     * @return string
     */
    public function getAccessKey()
    {
        return $this->accessKey;
    }

    /**
     * @param string $accessKey
     */
    public function setAccessKey($accessKey)
    {
        $this->accessKey = $accessKey;
    }

    /**
     * @return string
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * @param string $merchantId
     */
    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param string $environment
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
    }

    /**
     * @return string
     */
    public function getPaiementContractNumber()
    {
        return $this->paiementContractNumber;
    }

    /**
     * @param string $paiementContractNumber
     */
    public function setPaiementContractNumber($paiementContractNumber)
    {
        $this->paiementContractNumber = $paiementContractNumber;
    }

}
