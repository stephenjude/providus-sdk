<?php

declare(strict_types=1);

namespace Providus\Providus\Enums;

enum StatusResponse: string
{
    case SUCCESS = 'success';
    case DUPLICATE = 'duplicate transaction';
    case REJECTED = 'rejected transaction';
}
