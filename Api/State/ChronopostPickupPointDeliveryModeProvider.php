<?php

namespace ChronopostPickupPoint\Api\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ChronopostPickupPoint\Api\Resource\ChronopostPickupPointDeliveryModeResource;
use ChronopostPickupPoint\Config\ChronopostPickupPointConst;
use ChronopostPickupPoint\Model\ChronopostPickupPointDeliveryModeQuery;
use Thelia\Model\LangQuery;
use Symfony\Component\HttpFoundation\RequestStack;

class ChronopostPickupPointDeliveryModeProvider implements ProviderInterface
{
    public function __construct(
        private RequestStack $requestStack
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $config = ChronopostPickupPointConst::getConfig();
        $enabledDeliveryTypes = [];
        foreach (ChronopostPickupPointConst::getDeliveryTypesStatusKeys() as $deliveryTypeName => $statusKey) {
            if (!empty($config[$statusKey])) {
                $code = ChronopostPickupPointConst::CHRONOPOST_PICKUP_POINT_DELIVERY_CODES[$deliveryTypeName] ?? null;
                if (!empty($code)) {
                    $enabledDeliveryTypes[] = $code;
                }
            }
        }

        $query = ChronopostPickupPointDeliveryModeQuery::create();

        if (!empty($enabledDeliveryTypes)) {
            $query->filterByCode($enabledDeliveryTypes);
        }

        // Item by ID
        if (isset($uriVariables['id'])) {
            $mode = $query->findPk($uriVariables['id']);
            if (!$mode) return null;
            return $this->mapEntityToResource($mode);
        }

        // Collection
        $resources = [];
        foreach ($query->find() as $mode) {
            $resources[] = $this->mapEntityToResource($mode);
        }
        return $resources;
    }

    private function mapEntityToResource($mode): ChronopostPickupPointDeliveryModeResource
    {
        $resource = new ChronopostPickupPointDeliveryModeResource();
        $resource->id = $mode->getId();
        $resource->code = $mode->getCode();
        $resource->freeshippingActive = $mode->getFreeshippingActive();
        $resource->freeshippingFrom = $mode->getFreeshippingFrom();

        $locale = $this->resolveLocale();
        if ($locale) {
            $mode->setLocale($locale);
        }
        $resource->title = $mode->getTitle();

        return $resource;
    }

    private function resolveLocale(): ?string
    {
        $request = $this->requestStack->getCurrentRequest();
        if (!$request) return null;

        $langId = $request->get('lang_id');
        if ($langId) {
            $lang = LangQuery::create()->findPk($langId);
            if ($lang) return $lang->getLocale();
        }
        $session = $request->getSession();
        if ($session->has('thelia.current.lang')) {
            return $session->get('thelia.current.lang')->getLocale();
        }
        if ($session->has('thelia.current.admin_lang')) {
            return $session->get('thelia.current.admin_lang')->getLocale();
        }
        return 'fr_FR';
    }
}
