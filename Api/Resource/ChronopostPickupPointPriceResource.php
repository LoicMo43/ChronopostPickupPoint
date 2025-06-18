<?php

namespace ChronopostPickupPoint\Api\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Propel\Runtime\Map\TableMap;
use ChronopostPickupPoint\Model\Map\ChronopostPickupPointPriceTableMap;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;
use Thelia\Api\Resource\PropelResourceInterface;
use Thelia\Api\Resource\PropelResourceTrait;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/front/chronopost-pickup-point-price/{id}',
            name: 'api_chronopost_pickup_point_price_get_front'
        ),
        new GetCollection(
            uriTemplate: '/front/chronopost-pickup-point-prices',
            name: 'api_chronopost_pickup_point_price_get_collection_front'
        ),
    ],
    normalizationContext: ['groups' => [self::GROUP_FRONT_READ]]
)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/admin/chronopost-pickup-point-price/{id}',
            name: 'api_chronopost_pickup_point_price_get_admin'
        ),
        new GetCollection(
            uriTemplate: '/admin/chronopost-pickup-point-prices',
            name: 'api_chronopost_pickup_point_price_get_collection_admin'
        ),
    ],
    normalizationContext: ['groups' => [self::GROUP_ADMIN_READ]]
)]
class ChronopostPickupPointPriceResource implements PropelResourceInterface
{
    use PropelResourceTrait;

    public const GROUP_ADMIN_READ = 'admin:chronopost_pickup_point_price:read';
    public const GROUP_FRONT_READ = 'front:chronopost_pickup_point_price:read';

    #[Groups([self::GROUP_ADMIN_READ, self::GROUP_FRONT_READ])]
    public ?int $id = null;

    #[Groups([self::GROUP_ADMIN_READ, self::GROUP_FRONT_READ])]
    public ?float $weightMax = null;

    #[Groups([self::GROUP_ADMIN_READ, self::GROUP_FRONT_READ])]
    public ?float $priceMax = null;

    #[Groups([self::GROUP_ADMIN_READ, self::GROUP_FRONT_READ])]
    public ?float $price = null;

    #[Groups([self::GROUP_ADMIN_READ, self::GROUP_FRONT_READ])]
    public ?float $franco = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return void
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return float|null
     */
    public function getWeightMax(): ?float
    {
        return $this->weightMax;
    }

    /**
     * @param float|null $weightMax
     * @return void
     */
    public function setWeightMax(?float $weightMax): void
    {
        $this->weightMax = $weightMax;
    }

    /**
     * @return float|null
     */
    public function getPriceMax(): ?float
    {
        return $this->priceMax;
    }

    /**
     * @param float|null $priceMax
     * @return void
     */
    public function setPriceMax(?float $priceMax): void
    {
        $this->priceMax = $priceMax;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     * @return void
     */
    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return float|null
     */
    public function getFranco(): ?float
    {
        return $this->franco;
    }

    /**
     * @param float|null $franco
     * @return void
     */
    public function setFranco(?float $franco): void
    {
        $this->franco = $franco;
    }

    #[Ignore]
    public static function getPropelRelatedTableMap(): ?TableMap
    {
        return new ChronopostPickupPointPriceTableMap();
    }
}
