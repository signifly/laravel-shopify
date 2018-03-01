<?php

namespace Signifly\Shopify\Laravel;

use Signifly\Shopify\Shopify as BaseShopify;
use Signifly\Shopify\Profiles\ProfileContract;

class Shopify extends BaseShopify
{
    /**
     * Swap the Guzzle HTTP Client instance.
     *
     * NOTE: This method is in place in the laravel package because it provides
     * a laravel facade, which implements its own `swap()` method, effectively
     * hiding Shopify::swap().
     *
     * @param  ProfileContract $profile
     * @return self
     */
    public function swapProfile(ProfileContract $profile) : self
    {
        return parent::swap($profile);
    }
}
