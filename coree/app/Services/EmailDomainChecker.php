<?php

namespace App\Services;

use App\Models\Setting;

class EmailDomainChecker
{
    protected array $allowedDomains = [];

    public function __construct()
    {
        $allowedEmailString = Setting::getValue('allowed_email') ?? '';

        $domains = array_filter(array_map('trim', explode(',', $allowedEmailString)));

        $this->allowedDomains = $domains;
    }

    public function isAllowedDomain(string $email): bool
    {
        $domain = strtolower(substr(strrchr($email, "@"), 1));

        return in_array($domain, $this->allowedDomains, true);
    }
}
