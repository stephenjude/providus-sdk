<?php

namespace Providus\Providus\Facades;

use Illuminate\Support\Facades\Facade;
use Providus\Providus\Resources\AccountResource;
use Providus\Providus\Resources\TransactionResource;

/**
 * @see \Providus\Providus\Providus
 *
 * @method createReservedAccountNumber(string $name, string $bvn): AccountResource
 * @method createDynamicAccountNumber(string $name): AccountResource
 * @method updateAccountName(string $name, string $accountNumber): array
 * @method blacklistAccountNumber(string $accountNumber): array
 * @method verifyTransactionBySessionId(string $sessionId): TransactionResource
 * @method verifyTransactionBySettlementId(string $settlementId): TransactionResource
 */
class Providus extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Providus\Providus\Providus::class;
    }
}
