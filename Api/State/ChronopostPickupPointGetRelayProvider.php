<?php

namespace ChronopostPickupPoint\Api\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ChronopostPickupPoint\Api\Resource\ChronopostPickupPointRelay;
use ChronopostPickupPoint\Controller\ChronopostPickupPointRelayController;
use Thelia\Model\AddressQuery;
use Thelia\Model\CountryQuery;
use Symfony\Component\HttpFoundation\RequestStack;
use ErrorException;

class ChronopostPickupPointGetRelayProvider implements ProviderInterface
{
    public function __construct(
        private RequestStack $requestStack
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $request = $this->requestStack->getCurrentRequest();
        $orderWeight = $request->query->get('orderweight');
        $zipcode = $request->query->get('zipcode');
        $city = $request->query->get('city');
        $countryId = $request->query->get('countryid');
        $address1 = $request->query->get('address');
        $addressId = $request->query->get('address_id');

        $address = [];

        try {
            if (!empty($addressId) && (!empty($zipcode) || !empty($city))) {
                throw new \InvalidArgumentException(
                    "Cannot have argument 'address' and 'zipcode' or 'city' at the same time."
                );
            }

            if ($addressId && null !== $addressModel = AddressQuery::create()->findPk($addressId)) {
                $address = [
                    'orderweight' => $orderWeight,
                    'zipcode'     => $addressModel->getZipcode(),
                    'city'        => $addressModel->getCity(),
                    'address'     => $addressModel->getAddress1(),
                    'countrycode' => $addressModel->getCountry()->getIsoalpha2()
                ];
            } elseif (empty($zipcode) || empty($city)) {
                throw new ErrorException('Customer not connected or no default address.');
            } else {
                $countryCode = null;
                if ($countryId) {
                    $country = CountryQuery::create()->findOneById($countryId);
                    $countryCode = $country ? $country->getIsoalpha2() : null;
                }
                $address = [
                    'orderweight' => $orderWeight,
                    'zipcode'     => $zipcode,
                    'city'        => $city,
                    'address'     => $address1,
                    'countrycode' => $countryCode
                ];
            }
        } catch (\Exception $e) {
            return [];
        }

        $controller = new ChronopostPickupPointRelayController();
        try {
            $response = $controller->findByAddress(
                $address['orderweight'],
                $address['address'],
                $address['zipcode'],
                $address['city'],
                $address['countrycode']
            );
        } catch (\Exception $e) {
            $response = [];
        }

        if (!is_array($response) && $response !== null) {
            $response = [$response];
        }

        $resources = [];
        foreach ($response as $item) {
            $resource = new ChronopostPickupPointRelay();
            $resource->id = $item['identifiant'] ?? null;
            $resource->name = $item['nom'] ?? null;
            $resource->address = $item['adresse'] ?? null;
            $resource->zipcode = $item['codePostal'] ?? null;
            $resource->city = $item['localite'] ?? null;
            $resource->countryCode = $address['countrycode'] ?? null;

            $distance = $item['distanceEnMetre'] ?? null;
            if ($distance !== null) {
                $distance = (string) $distance;
                if (strlen($distance) < 4) {
                    $distance .= ' m';
                } else {
                    $distance = (string)((float)$distance / 1000);
                    while (str_ends_with($distance, "0")) {
                        $distance = substr($distance, 0, -1);
                    }
                    $distance = str_replace('.', ',', $distance) . ' km';
                }
                $resource->distance = $distance;
            }

            $resources[] = $resource;
        }
        return $resources;
    }
}
