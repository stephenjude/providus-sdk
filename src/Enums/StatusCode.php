<?php

declare(strict_types=1);

namespace Providus\Providus\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

enum StatusCode: string
{
    use InvokableCases;
    use Options;
    use Names;
    use Values;
    case  SUCCESS = '00';
    case  DUPLICATE = '01';
    case  REJECTED = '02';
}
