<?php

namespace Signifly\Shopify\Laravel\Profiles;

use Signifly\Shopify\Profiles\CredentialsProfile;

class ConfigProfile extends CredentialsProfile
{
    public function __construct()
    {
        $config = config('shopify');

        parent::__construct($config['api_key'], $config['password'], $config['handle']);
    }
}
