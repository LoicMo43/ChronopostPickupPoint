<?php

namespace ChronopostPickupPoint\Api\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ChronopostPickupPoint\Api\State\ChronopostPickupPointGetRelayProvider;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/front/chronopost-pickup-point-relays',
            name: 'api_chronopost_pickup_point_relays_get_collection',
            provider: ChronopostPickupPointGetRelayProvider::class
        ),
    ],
    normalizationContext: ['groups' => ['front:chronopost_pickup_point_relay:read']]
)]
class ChronopostPickupPointRelayResource
{
    #[Groups(['front:chronopost_pickup_point_relay:read'])]
    public ?string $id = null;

    #[Groups(['front:chronopost_pickup_point_relay:read'])]
    public ?string $name = null;

    #[Groups(['front:chronopost_pickup_point_relay:read'])]
    public ?string $address = null;

    #[Groups(['front:chronopost_pickup_point_relay:read'])]
    public ?string $zipcode = null;

    /**
     * @var string|null
     */
    #[Groups(['front:chronopost_pickup_point_relay:read'])]
    public ?string $city = null;

    /**
     * @var string|null
     */
    #[Groups(['front:chronopost_pickup_point_relay:read'])]
    public ?string $countryCode = null;

    #[Groups(['front:chronopost_pickup_point_relay:read'])]
    public ?string $distance = null;

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return void
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return void
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     * @return void
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string|null
     */
    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    /**
     * @param string|null $zipcode
     * @return void
     */
    public function setZipcode(?string $zipcode): void
    {
        $this->zipcode = $zipcode;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     * @return void
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
    }
}
