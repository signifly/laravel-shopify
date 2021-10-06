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

    public function createPriceRule(array $data): ApiResource
    {
        return $this->createResource('price_rules', $data);
    }

    public function getPriceRulesCount(array $params = []): int
    {
        return $this->getResourceCount('price_rules', $params);
    }

    public function paginatePriceRules(array $params = []): Cursor
    {
        return $this->cursor($this->getPriceRules($params));
    }

    public function getPriceRules(array $params = []): Collection
    {
        return $this->getResources('price_rules', $params);
    }

    public function getPriceRule($priceRuleId): ApiResource
    {
        return $this->getResource('price_rules', $priceRuleId);
    }

    public function updatePriceRule($priceRuleId, $data): ApiResource
    {
        return $this->updateResource('price_rules', $priceRuleId, $data);
    }

    public function deletePriceRule($priceRuleId): void
    {
        $this->deleteResource('price_rules', $priceRuleId);
    }
}
