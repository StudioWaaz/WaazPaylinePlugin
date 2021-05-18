<?php
/**
 * @author    Matthieu Vion
 * @copyright 2018 Magentix
 * @license   https://opensource.org/licenses/GPL-3.0 GNU General Public License version 3
 * @link      https://github.com/magentix/mondial-relay-plugin
 */
declare(strict_types=1);

namespace Waaz\SyliusMondialRelayPlugin\Repository;

use Waaz\SyliusMondialRelayPlugin\Model\Soap;

class PickupRepository extends Soap
{

    /**
     * @var array $config
     */
    private $config;

    /**
     * @param array $config
     * @return void
     */
    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    /**
     * Find pickup with identifier
     *
     * @param string $pickupId
     * @param string $countryCode
     * @return array
     */
    public function find(string $pickupId, string $countryCode = 'FR'): array
    {
        $data = [
            'NumPointRelais' => $pickupId,
            'Pays'           => $countryCode,
        ];

        return $this->execute('WSI4_PointRelais_Recherche', $data, $this->config);
    }

    /**
     * Find list of pickup near country and postcode
     *
     * @param string $postcode
     * @param string $countryCode
     * @param string $shippingCode
     * @param int $number
     * @return array
     */
    public function findAll(
        string $postcode,
        string $countryCode = 'FR',
        string $shippingCode = '24R',
        int $number = 10
    ): array {
        $data = [
            'Pays'            => $countryCode,
            'CP'              => $postcode,
            'Action'          => $shippingCode,
            'NombreResultats' => $number
        ];

        return $this->execute('WSI4_PointRelais_Recherche', $data, $this->config);
    }

    /**
     * Create Shipping
     *
     * @param array $data
     * @return array
     */
    public function createShipping(array $data): array
    {
        return $this->execute('WSI2_CreationExpedition', $data, $this->config);
    }

    /**
     * Retrieve label
     *
     * @param array $data
     * @return array
     */
    public function getLabel(array $data): array
    {
        return $this->execute('WSI3_GetEtiquettes', $data, $this->config);
    }
}
