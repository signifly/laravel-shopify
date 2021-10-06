<?php

namespace Signifly\Shopify\REST\Actions;

use Illuminate\Support\Collection;
use Signifly\Shopify\REST\Resources\ApiResource;
use Signifly\Shopify\Shopify;

/** @mixin Shopify */
trait ManagesDiscounts
{
    public function createDiscountCode($priceRuleId, string $code): ApiResource
    {
        return $this->createResource('discount_codes', ['code' => $code], ['price_rules', $priceRuleId]);
    }

    public function getDiscountCodesCount(array $params = []): int
    {
        return $this->getResourceCount('discount_codes', $params);
    }

    public function getDiscountCodes($priceRuleId, array $params = []): Collection
    {
        return $this->getResources('discount_codes', $params, ['price_rules', $priceRuleId]);
    }

    public function getDiscountCode($priceRuleId, $discountCodeId): ApiResource
    {
        return $this->getResource('discount_codes', $discountCodeId, ['price_rules', $priceRuleId]);
    }

    public function updateDiscountCode($priceRuleId, $discountCodeId, string $code): ApiResource
    {
        return $this->updateResource('discount_codes', $discountCodeId, ['code' => $code], ['price_rules', $priceRuleId]);
    }

    public function deleteDiscountCode($priceRuleId, $discountCodeId): void
    {
        $this->deleteResource('discount_codes', $discountCodeId, ['price_rules', $priceRuleId]);
    }
}
