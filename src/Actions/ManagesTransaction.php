<?php

declare(strict_types=1);

namespace Providus\Providus\Actions;

use Providus\Providus\Resources\TransactionResource;

trait ManagesTransaction
{
    public function verifyTransactionBySessionId(string $sessionId): TransactionResource
    {
        $transaction = $this->get(uri: "PiPverifyTransaction?session_id=$sessionId");

        $this->checkAndHandleProvidusError(data: $transaction, key: 'sessionId');

        return new TransactionResource($transaction);
    }

    public function verifyTransactionBySettlementId(string $settlementId): TransactionResource
    {
        $transaction = $this->get(uri: "PiPverifyTransaction?settlement_id=$settlementId");

        $this->checkAndHandleProvidusError(data: $transaction, key: 'settlementId');

        return new TransactionResource($transaction);
    }
}
