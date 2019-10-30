<?php

/**
 * This file was created by the developers from Waaz.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://www.studiowaaz.com and write us
 * an email on developpement@studiowaaz.com.
 */

namespace Waaz\PaylinePlugin\Bridge;

use Waaz\PaylinePlugin\Legacy\SimplePay;

/**
 * @author Ibes Mongabure <developpement@studiowaaz.com>
 */
interface PaylineBridgeInterface
{
    /**
     * @param string $accessKey
     *
     * @return SimplePay
     */
    public function createPayline($accessKey);

    /**
     * @return bool
     */
    public function paymentVerification();

    /**
     * @return bool
     */
    public function isGetMethod();

    /**
     * @return string
     */
    public function getAccessKey();

    /**
     * @param string $accessKey
     */
    public function setAccessKey($accessKey);

    /**
     * @return string
     */
    public function getMerchantId();

    /**
     * @param string $merchantId
     */
    public function setMerchantId($merchantId);

    /**
     * @return string
     */
    public function getEnvironment();

    /**
     * @param string $environment
     */
    public function setEnvironment($environment);

    /**
     * @return string
     */
    public function getPaiementContractNumber();

    /**
     * @param string $paiementContractNumber
     */
    public function setPaiementContractNumber($paiementContractNumber);
}
