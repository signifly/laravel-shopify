<?php

namespace Signifly\Shopify\REST\Actions;

use Signifly\Shopify\REST\Resources\BalanceResource;
use Signifly\Shopify\Shopify;

/** @mixin Shopify */
trait ManagesShopifyPayments
{
    public function getBalance(): BalanceResource
    {
        $response = $this->get('shopify_payments/balance');

        return new BalanceResource($response['balance'], $this);
    }
}
