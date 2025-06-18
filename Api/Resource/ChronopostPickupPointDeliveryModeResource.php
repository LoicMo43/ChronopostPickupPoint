<?php

namespace ChronopostPickupPoint\Api\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Propel\Runtime\Map\TableMap;
use ChronopostPickupPoint\Model\Map\ChronopostPickupPointDeliveryModeTableMap;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;
use Thelia\Api\Resource\PropelResourceInterface;
use Thelia\Api\Resource\PropelResourceTrait;
use ChronopostPickupPoint\Api\State\ChronopostPickupPointDeliveryModeProvider;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/front/chronopost-pickup-point-delivery-mode/{id}',
            name: 'api_chronopost_pickup_point_delivery_mode_get_front',
            provider: ChronopostPickupPointDeliveryModeProvider::class
        ),
        new GetCollection(
            uriTemplate: '/front/chronopost-pickup-point-delivery-modes',
            name: 'api_chronopost_pickup_point_delivery_mode_get_collection_front',
            provider: ChronopostPickupPointDeliveryModeProvider::class
        ),
    ],
    normalizationContext: ['groups' => [self::GROUP_FRONT_READ]]
)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/admin/chronopost-pickup-point-delivery-mode/{id}',
            name: 'api_chronopost_pickup_point_delivery_mode_get_admin',
            provider: ChronopostPickupPointDeliveryModeProvider::class
        ),
        new GetCollection(
            uriTemplate: '/admin/chronopost-pickup-point-delivery-modes',
            name: 'api_chronopost_pickup_point_delivery_mode_get_collection_admin',
            provider: ChronopostPickupPointDeliveryModeProvider::class
        ),
    ],
    normalizationContext: ['groups' => [self::GROUP_ADMIN_READ]]
)]
class ChronopostPickupPointDeliveryModeResource implements PropelResourceInterface
{
    use PropelResourceTrait;

    public const GROUP_ADMIN_READ = 'admin:chronopost_pickup_point_delivery_mode:read';
    public const GROUP_FRONT_READ = 'front:chronopost_pickup_point_delivery_mode:read';

    /**
     * @var int|null
     */
    #[Groups([self::GROUP_ADMIN_READ, self::GROUP_FRONT_READ])]
    public ?int $id = null;

    /**
     * @var string|null
     */
    #[Groups([self::GROUP_ADMIN_READ, self::GROUP_FRONT_READ])]
    public ?string $title = null;

    /**
     * @var string|null
     */
    #[Groups([self::GROUP_ADMIN_READ, self::GROUP_FRONT_READ])]
    public ?string $code = null;

    /**
     * @var bool|null
     */
    #[Groups([self::GROUP_ADMIN_READ, self::GROUP_FRONT_READ])]
    public ?bool $freeshippingActive = null;

    /**
     * @var float|null
     */
    #[Groups([self::GROUP_ADMIN_READ, self::GROUP_FRONT_READ])]
    public ?float $freeshippingFrom = null;

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
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return void
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     * @return void
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return bool|null
     */
    public function getFreeshippingActive(): ?bool
    {
        return $this->freeshippingActive;
    }

    /**
     * @param bool|null $freeshippingActive
     * @return void
     */
    public function setFreeshippingActive(?bool $freeshippingActive): void
    {
        $this->freeshippingActive = $freeshippingActive;
    }

    /**
     * @return float|null
     */
    public function getFreeshippingFrom(): ?float
    {
        return $this->freeshippingFrom;
    }

    /**
     * @param float|null $freeshippingFrom
     * @return void
     */
    public function setFreeshippingFrom(?float $freeshippingFrom): void
    {
        $this->freeshippingFrom = $freeshippingFrom;
    }

    /**
     * @return TableMap|null
     */
    #[Ignore]
    public static function getPropelRelatedTableMap(): ?TableMap
    {
        return new ChronopostPickupPointDeliveryModeTableMap();
    }
}
