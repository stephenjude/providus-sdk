<?php

declare(strict_types=1);

namespace Providus\Providus\Enums;

enum StatusCode: string
{
    case  SUCCESS = '00';
    case  DUPLICATE = '01';
    case  REJECTED = '02';
}
