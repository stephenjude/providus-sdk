<?php

declare(strict_types=1);

namespace Providus\Providus\Resources;

class AccountResource extends BaseResource
{
    public string $accountNumber;

    public string $accountName;

    public ?string $bvn;
}
