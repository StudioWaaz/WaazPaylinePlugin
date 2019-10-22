<?php

/**
 * This file was created by the developers from Waaz.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://www.studiowaaz.com and write us
 * an email on developpement@studiowaaz.com.
 */

namespace Waaz\PaylinePlugin;

use Waaz\PaylinePlugin\Action\ConvertPaymentAction;
use Waaz\PaylinePlugin\Bridge\PaylineBridgeInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;

/**
 * @author Ibes Mongabure <developpement@studiowaaz.com>
 */
final class PaylineGatewayFactory extends GatewayFactory
{
    /**
     * {@inheritDoc}
     */
    protected function populateConfig(ArrayObject $config)
    {
        $config->defaults([
            'payum.factory_name' => 'payline',
            'payum.factory_title' => 'Payline - Crédit Mutuelle',

            'payum.action.convert' => new ConvertPaymentAction(),

            'payum.http_client' => '@waaz.payline.bridge.payline_bridge',
        ]);

        if (false == $config['payum.api']) {
            $config['payum.default_options'] = [
                'environment' => '',
                'access_key' => '',
                'merchant_id' => '',
                'contract_number' => '',
            ];

            $config->defaults($config['payum.default_options']);
            $config['payum.required_options'] = ['access_key', 'environment', 'merchant_id', 'contract_number'];

            $config['payum.api'] = function (ArrayObject $config) {
                $config->validateNotEmpty($config['payum.required_options']);

                /** @var PaylineBridgeInterface $payline */
                $payline = $config['payum.http_client'];

                $payline->setAccessKey($config['access_key']);
                $payline->setMerchantId($config['merchant_id']);
                $payline->setEnvironment($config['environment']);
                $payline->setPaiementContractNumber($config['contract_number']);

                return $payline;
            };
        }
    }
}
